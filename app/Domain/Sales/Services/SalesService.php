<?php

namespace App\Domain\Sales\Services;

use App\Domain\Inventory\Models\ProductPackage;
use App\Domain\Inventory\Services\FinishedInventoryService;
use App\Domain\Production\Models\ProductionBatch;
use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Models\SaleItem;
use DomainException;
use Illuminate\Support\Facades\DB;

class SalesService
{
    public function __construct(private readonly FinishedInventoryService $finishedInventoryService)
    {
    }

    public function createSale(array $data): Sale
    {
        if (empty($data['items'])) {
            throw new DomainException('A sale requires at least one item.');
        }

        return DB::transaction(function () use ($data) {
            $sale = Sale::query()->create([
                'invoice_number' => $data['invoice_number'],
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'] ?? null,
                'customer_address' => $data['customer_address'] ?? null,
                'location_id' => $data['location_id'],
                'payment_method' => $data['payment_method'],
                'delivery_status' => $data['delivery_status'] ?? 'pending',
                'total_amount' => 0,
                'sale_date' => $data['sale_date'],
            ]);

            $total = 0.0;

            foreach ($data['items'] as $item) {
                $package = ProductPackage::query()->findOrFail($item['product_package_id']);

                if ((int) $package->product_id !== (int) $item['product_id']) {
                    throw new DomainException('Selected package does not belong to selected product.');
                }

                if (! empty($item['production_batch_id'])) {
                    $batch = ProductionBatch::query()->findOrFail($item['production_batch_id']);

                    if ((int) $batch->location_id !== (int) $sale->location_id) {
                        throw new DomainException('Production batch location must match sale location.');
                    }
                }

                $this->finishedInventoryService->assertSufficientStock(
                    locationId: (int) $sale->location_id,
                    productId: (int) $item['product_id'],
                    packageId: (int) $item['product_package_id'],
                    requiredQuantity: (float) $item['quantity'],
                );

                $lineTotal = round(((float) $item['quantity']) * ((float) $item['price']), 2);

                $saleItem = SaleItem::query()->create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'product_package_id' => $item['product_package_id'],
                    'production_batch_id' => $item['production_batch_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'line_total' => $lineTotal,
                ]);

                $this->finishedInventoryService->moveOutForSale(
                    batchId: isset($item['production_batch_id']) ? (int) $item['production_batch_id'] : null,
                    productId: (int) $item['product_id'],
                    packageId: (int) $item['product_package_id'],
                    locationId: (int) $sale->location_id,
                    quantity: (float) $item['quantity'],
                    referenceId: (int) $saleItem->id,
                    dateTime: $sale->sale_date->toDateString() . ' 00:00:00',
                );

                $total += $lineTotal;
            }

            $sale->update(['total_amount' => round($total, 2)]);

            return $sale->load(['items']);
        });
    }
}
