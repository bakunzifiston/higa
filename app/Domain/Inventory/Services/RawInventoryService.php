<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Models\RawInventoryMovement;
use DomainException;
use Illuminate\Support\Facades\DB;

class RawInventoryService
{
    public function currentStockByLocation(int $locationId): float
    {
        $incoming = (float) RawInventoryMovement::query()
            ->where('location_id', $locationId)
            ->where('type', RawInventoryMovement::TYPE_IN)
            ->sum('quantity');

        $outgoing = (float) RawInventoryMovement::query()
            ->where('location_id', $locationId)
            ->where('type', RawInventoryMovement::TYPE_OUT)
            ->sum('quantity');

        return round($incoming - $outgoing, 3);
    }

    public function assertSufficientStock(int $locationId, float $requiredQuantity): void
    {
        if ($requiredQuantity <= 0) {
            throw new DomainException('Required raw quantity must be greater than zero.');
        }

        $available = $this->currentStockByLocation($locationId);

        if ($available + 1e-6 < $requiredQuantity) {
            throw new DomainException('Insufficient raw stock for this location.');
        }
    }

    public function moveInFromCollection(int $locationId, int $collectionId, float $quantity, string $dateTime): RawInventoryMovement
    {
        return RawInventoryMovement::query()->create([
            'type' => RawInventoryMovement::TYPE_IN,
            'source' => RawInventoryMovement::SOURCE_COLLECTION,
            'quantity' => $quantity,
            'location_id' => $locationId,
            'reference_id' => $collectionId,
            'movement_date' => $dateTime,
        ]);
    }

    public function moveOutToProduction(int $locationId, int $batchId, float $quantity, string $dateTime): RawInventoryMovement
    {
        return RawInventoryMovement::query()->create([
            'type' => RawInventoryMovement::TYPE_OUT,
            'source' => RawInventoryMovement::SOURCE_PRODUCTION,
            'quantity' => $quantity,
            'location_id' => $locationId,
            'reference_id' => $batchId,
            'movement_date' => $dateTime,
        ]);
    }

    /**
     * FIFO: consume from oldest maize collections first.
     * Creates one OUT movement per maize collection lot (spill into next as needed).
     */
    public function moveOutToProductionFifoFromCollections(
        int $locationId,
        int $productionBatchId,
        float $quantity,
        string $dateTime
    ): void {
        $remaining = round($quantity, 3);
        if ($remaining <= 0) {
            throw new DomainException('Production maize_used must be greater than zero.');
        }

        // Incoming lots (collections) with remaining quantity derived from ledger.
        // For each collection: remaining = accepted_in - accepted_out_for_that_collection.
        $lots = DB::table('raw_inventory_movements as in_m')
            ->select([
                'in_m.maize_collection_id',
                DB::raw('in_m.location_id as location_id'),
                DB::raw('in_m.movement_date as movement_date'),
                DB::raw('in_m.quantity as incoming_qty'),
            ])
            ->where('in_m.location_id', $locationId)
            ->where('in_m.type', RawInventoryMovement::TYPE_IN)
            ->where('in_m.source', RawInventoryMovement::SOURCE_COLLECTION)
            ->whereNotNull('in_m.maize_collection_id')
            ->orderBy('in_m.movement_date', 'asc')
            ->orderBy('in_m.id', 'asc')
            ->get()
            ->map(function ($lot) {
                $outQty = (float) DB::table('raw_inventory_movements as out_m')
                    ->where('out_m.location_id', $lot->location_id)
                    ->where('out_m.type', RawInventoryMovement::TYPE_OUT)
                    ->where('out_m.source', RawInventoryMovement::SOURCE_PRODUCTION)
                    ->where('out_m.maize_collection_id', $lot->maize_collection_id)
                    ->sum('out_m.quantity');

                $remainingLot = round(((float) $lot->incoming_qty) - $outQty, 3);
                return [
                    'maize_collection_id' => (int) $lot->maize_collection_id,
                    'remaining_lot' => $remainingLot,
                ];
            })
            ->filter(fn ($x) => $x['remaining_lot'] > 1e-6)
            ->values();

        foreach ($lots as $lot) {
            if ($remaining <= 1e-6) {
                break;
            }

            $consume = min($remaining, (float) $lot['remaining_lot']);

            RawInventoryMovement::query()->create([
                'type' => RawInventoryMovement::TYPE_OUT,
                'source' => RawInventoryMovement::SOURCE_PRODUCTION,
                'quantity' => round($consume, 3),
                'location_id' => $locationId,
                'maize_collection_id' => (int) $lot['maize_collection_id'],
                'production_batch_id' => $productionBatchId,
                'reference_id' => $productionBatchId,
                'movement_date' => $dateTime,
            ]);

            $remaining = round($remaining - $consume, 3);
        }

        if ($remaining > 1e-6) {
            throw new DomainException('FIFO consumption failed: not enough remaining maize lots for the location.');
        }
    }


    public function averageRawMaterialCostPerKg(int $locationId): float
    {
        $totals = DB::table('maize_collections')
            ->selectRaw('SUM(accepted_quantity * price_per_kg) as total_cost, SUM(accepted_quantity) as total_qty')
            ->where('location_id', $locationId)
            ->first();

        $qty = (float) ($totals->total_qty ?? 0);

        if ($qty <= 0) {
            return 0.0;
        }

        return round(((float) $totals->total_cost) / $qty, 4);
    }
}
