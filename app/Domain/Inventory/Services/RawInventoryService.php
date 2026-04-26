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
