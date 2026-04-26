<?php

namespace App\Domain\Sales\Services;

use App\Domain\Inventory\Services\FinishedInventoryService;
use App\Domain\Sales\Models\SaleItem;
use App\Domain\Sales\Models\SaleReturn;
use DomainException;
use Illuminate\Support\Facades\DB;

class SalesReturnService
{
    public function __construct(private readonly FinishedInventoryService $finishedInventoryService)
    {
    }

    public function processReturn(array $data): SaleReturn
    {
        return DB::transaction(function () use ($data) {
            $saleItem = SaleItem::query()->with('sale')->findOrFail($data['sale_item_id']);

            if ((int) $saleItem->sale_id !== (int) $data['sale_id']) {
                throw new DomainException('Sale item does not belong to the provided sale.');
            }

            $returnedBefore = (float) SaleReturn::query()
                ->where('sale_item_id', $saleItem->id)
                ->sum('quantity');

            $requested = (float) $data['quantity'];
            $sold = (float) $saleItem->quantity;

            if ($requested <= 0 || ($returnedBefore + $requested) - $sold > 0.001) {
                throw new DomainException('Return quantity exceeds sold quantity.');
            }

            $refundAmount = round($requested * (float) $saleItem->price, 2);

            $return = SaleReturn::query()->create([
                'sale_id' => $data['sale_id'],
                'sale_item_id' => $saleItem->id,
                'quantity' => $data['quantity'],
                'reason' => $data['reason'],
                'refund_status' => $data['refund_status'] ?? 'pending',
                'refund_amount' => $refundAmount,
                'return_date' => $data['return_date'],
            ]);

            $this->finishedInventoryService->moveInFromReturn(
                batchId: $saleItem->production_batch_id ? (int) $saleItem->production_batch_id : null,
                productId: (int) $saleItem->product_id,
                packageId: (int) $saleItem->product_package_id,
                locationId: (int) $saleItem->sale->location_id,
                quantity: $requested,
                referenceId: (int) $return->id,
                dateTime: $return->return_date->toDateString() . ' 00:00:00',
            );

            return $return;
        });
    }
}
