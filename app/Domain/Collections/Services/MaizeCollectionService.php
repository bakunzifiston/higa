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
                'collection_date' => $data['collection_date'],
                'quantity_collected' => $data['quantity_collected'],
                'quantity_rejected' => $data['quantity_rejected'] ?? 0,
                'accepted_quantity' => $accepted,
                'price_per_kg' => $data['price_per_kg'],
                'rejection_reason' => $data['rejection_reason'] ?? null,
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
}
