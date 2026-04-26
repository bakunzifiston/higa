<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Models\FinishedInventoryMovement;
use DomainException;

class FinishedInventoryService
{
    public function currentStock(int $locationId, int $productId, int $packageId): float
    {
        $incoming = (float) FinishedInventoryMovement::query()
            ->where('location_id', $locationId)
            ->where('product_id', $productId)
            ->where('product_package_id', $packageId)
            ->where('type', FinishedInventoryMovement::TYPE_IN)
            ->sum('quantity');

        $outgoing = (float) FinishedInventoryMovement::query()
            ->where('location_id', $locationId)
            ->where('product_id', $productId)
            ->where('product_package_id', $packageId)
            ->where('type', FinishedInventoryMovement::TYPE_OUT)
            ->sum('quantity');

        return round($incoming - $outgoing, 3);
    }

    public function assertSufficientStock(int $locationId, int $productId, int $packageId, float $requiredQuantity): void
    {
        if ($requiredQuantity <= 0) {
            throw new DomainException('Required finished quantity must be greater than zero.');
        }

        $available = $this->currentStock($locationId, $productId, $packageId);

        if ($available + 1e-6 < $requiredQuantity) {
            throw new DomainException('Insufficient finished stock for selected product/package/location.');
        }
    }

    public function moveInFromProduction(
        int $batchId,
        int $productId,
        int $packageId,
        int $locationId,
        float $quantity,
        int $referenceId,
        string $dateTime
    ): FinishedInventoryMovement {
        return FinishedInventoryMovement::query()->create([
            'type' => FinishedInventoryMovement::TYPE_IN,
            'source' => FinishedInventoryMovement::SOURCE_PRODUCTION,
            'production_batch_id' => $batchId,
            'product_id' => $productId,
            'product_package_id' => $packageId,
            'location_id' => $locationId,
            'quantity' => $quantity,
            'reference_id' => $referenceId,
            'movement_date' => $dateTime,
        ]);
    }

    public function moveOutForSale(
        ?int $batchId,
        int $productId,
        int $packageId,
        int $locationId,
        float $quantity,
        int $referenceId,
        string $dateTime
    ): FinishedInventoryMovement {
        return FinishedInventoryMovement::query()->create([
            'type' => FinishedInventoryMovement::TYPE_OUT,
            'source' => FinishedInventoryMovement::SOURCE_SALE,
            'production_batch_id' => $batchId,
            'product_id' => $productId,
            'product_package_id' => $packageId,
            'location_id' => $locationId,
            'quantity' => $quantity,
            'reference_id' => $referenceId,
            'movement_date' => $dateTime,
        ]);
    }

    public function moveInFromReturn(
        ?int $batchId,
        int $productId,
        int $packageId,
        int $locationId,
        float $quantity,
        int $referenceId,
        string $dateTime
    ): FinishedInventoryMovement {
        return FinishedInventoryMovement::query()->create([
            'type' => FinishedInventoryMovement::TYPE_IN,
            'source' => FinishedInventoryMovement::SOURCE_RETURN,
            'production_batch_id' => $batchId,
            'product_id' => $productId,
            'product_package_id' => $packageId,
            'location_id' => $locationId,
            'quantity' => $quantity,
            'reference_id' => $referenceId,
            'movement_date' => $dateTime,
        ]);
    }
}
