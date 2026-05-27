<?php

namespace App\Domain\Collections\Services;

use App\Domain\Collections\Models\MaizeCollection;
use App\Domain\Inventory\Services\RawInventoryService;
use DomainException;
use Illuminate\Support\Facades\DB;

class MaizeCollectionService
{
    public function __construct(private readonly RawInventoryService $rawInventoryService)
    {
    }

    public function record(array $data): MaizeCollection
    {
        $collected = (float) $data['quantity_collected'];
        $rejected = (float) ($data['quantity_rejected'] ?? 0);

        if ($rejected > $collected) {
            throw new DomainException('Rejected quantity cannot exceed collected quantity.');
        }

        $accepted = round($collected - $rejected, 3);

        if ($accepted <= 0) {
            throw new DomainException('Accepted quantity must be greater than zero.');
        }

        return DB::transaction(function () use ($data, $accepted) {
            $collection = MaizeCollection::query()->create([
                'farmer_id' => $data['farmer_id'],
                'location_id' => $data['location_id'],
                'product_name' => $data['product_name'] ?? null,
                'collection_date' => $data['collection_date'],
                'quantity_collected' => $data['quantity_collected'],
                'quantity_rejected' => $data['quantity_rejected'] ?? 0,
                'accepted_quantity' => $accepted,
                'price_per_kg' => $data['price_per_kg'],
                'rejection_reason' => $data['rejection_reason'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);


            $this->rawInventoryService->moveInFromCollection(
                locationId: (int) $collection->location_id,
                collectionId: (int) $collection->id,
                quantity: (float) $collection->accepted_quantity,
                dateTime: $collection->collection_date->toDateString() . ' 00:00:00',
            );

            return $collection;
        });
    }
<<<<<<< Updated upstream
=======

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): MaizeCollection
    {
        $accepted = $this->assertAcceptedQty($data);

        return DB::transaction(function () use ($id, $data, $accepted) {
            $collection = MaizeCollection::query()->lockForUpdate()->findOrFail($id);

            $movement = $this->findCollectionLedgerIn($collection->id);

            if (!$movement) {
                throw new DomainException('Raw inventory ledger row for this collection is missing. Run a data repair.');
            }

            $oldLoc = (int) $movement->location_id;
            $oldQty = (float) $movement->quantity;
            $newLoc = (int) $data['location_id'];
            $newQty = $accepted;

            if ($oldLoc !== $newLoc) {
                if ($this->rawInventoryService->currentStockByLocation($oldLoc) + 1e-6 < $oldQty) {
                    throw new DomainException(
                        'Cannot change warehouse: this collection\'s maize is no longer fully available at the source.'
                    );
                }
            } elseif ($accepted + 1e-6 < $oldQty) {
                $shrink = round($oldQty - $accepted, 3);
                if ($this->rawInventoryService->currentStockByLocation($oldLoc) + 1e-6 < $shrink) {
                    throw new DomainException(
                        'Cannot reduce accepted quantity: raw stock at this warehouse is no longer fully available.'
                    );
                }
            }

            $collection->update([
                'farmer_id' => $data['farmer_id'],
                'location_id' => $data['location_id'],
                'product_name' => $data['product_name'] ?? null,
                'collection_date' => $data['collection_date'],
                'quantity_collected' => $data['quantity_collected'],
                'quantity_rejected' => $data['quantity_rejected'] ?? 0,
                'accepted_quantity' => $accepted,
                'price_per_kg' => $data['price_per_kg'],
                'rejection_reason' => $data['rejection_reason'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);


            $collection->refresh();

            $movement->update([
                'location_id' => $newLoc,
                'quantity' => $newQty,
                'movement_date' => $collection->collection_date->toDateString() . ' 00:00:00',
                'maize_collection_id' => $collection->id,
                'reference_id' => $collection->id,
            ]);

            return $collection->fresh();
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $collection = MaizeCollection::query()->lockForUpdate()->findOrFail($id);
            $movement = $this->findCollectionLedgerIn($collection->id);

            $locationId = (int) $collection->location_id;
            $qty = $movement ? (float) $movement->quantity : 0.0;

            if ($movement && $qty > 1e-6) {
                $available = $this->rawInventoryService->currentStockByLocation($locationId);
                if ($available + 1e-6 < $qty) {
                    throw new DomainException(
                        'Cannot delete this collection: accepted maize was already consumed (e.g. production).'
                    );
                }
            }

            optional($movement)->delete();
            $collection->delete();
        });
    }

    private function findCollectionLedgerIn(int $collectionId): ?RawInventoryMovement
    {
        return RawInventoryMovement::query()
            ->where('type', RawInventoryMovement::TYPE_IN)
            ->where('source', RawInventoryMovement::SOURCE_COLLECTION)
            ->where(function ($q) use ($collectionId) {
                $q->where('maize_collection_id', $collectionId)
                    ->orWhere(function ($q2) use ($collectionId) {
                        $q2->whereNull('maize_collection_id')
                            ->where('reference_id', $collectionId);
                    });
            })
            ->first();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function assertAcceptedQty(array $data): float
    {
        $collected = (float) $data['quantity_collected'];
        $rejected = (float) ($data['quantity_rejected'] ?? 0);

        if ($rejected > $collected) {
            throw new DomainException('Rejected quantity cannot exceed collected quantity.');
        }

        $accepted = round($collected - $rejected, 3);

        if ($accepted <= 0) {
            throw new DomainException('Accepted quantity must be greater than zero.');
        }

        return $accepted;
    }
>>>>>>> Stashed changes
}
