<?php

namespace Database\Seeders;

use App\Domain\Collections\Services\MaizeCollectionService;
use App\Domain\Inventory\Models\Location;
use App\Domain\Inventory\Models\Product;
use App\Domain\Inventory\Models\ProductPackage;
use App\Domain\Production\Services\BatchExpenseService;
use App\Domain\Production\Services\ProductionService;
use App\Domain\Sales\Services\SalesService;
use App\Domain\Suppliers\Models\Farmer;
use Illuminate\Database\Seeder;

class ImsDemoFlowSeeder extends Seeder
{
    public function run(): void
    {
        $location = Location::query()->firstOrFail();
        $farmer = Farmer::query()->firstOrFail();
        $product = Product::query()->where('sku', 'KAWUNGA')->firstOrFail();
        $package = ProductPackage::query()
            ->where('product_id', $product->id)
            ->where('weight_kg', 25)
            ->firstOrFail();

        /** @var MaizeCollectionService $collectionService */
        $collectionService = app(MaizeCollectionService::class);

        $collectionService->record([
            'farmer_id' => $farmer->id,
            'location_id' => $location->id,
            'collection_date' => now()->subDays(4)->toDateString(),
            'quantity_collected' => 1200,
            'quantity_rejected' => 50,
            'price_per_kg' => 310,
            'rejection_reason' => 'Moisture above threshold',
        ]);

        /** @var ProductionService $productionService */
        $productionService = app(ProductionService::class);

        $batch = $productionService->createBatch([
            'batch_number' => 'BATCH-' . now()->format('Ymd-His'),
            'location_id' => $location->id,
            'maize_used' => 900,
            'quantity_produced' => 840,
            'wastage_quantity' => 60,
            'quality_percentage' => 96.5,
            'production_date' => now()->subDays(2)->toDateString(),
            'outputs' => [
                [
                    'product_id' => $product->id,
                    'product_package_id' => $package->id,
                    'quantity' => 840,
                ],
            ],
        ]);

        /** @var BatchExpenseService $expenseService */
        $expenseService = app(BatchExpenseService::class);

        foreach ([
            ['type' => 'labor', 'amount' => 85000],
            ['type' => 'transport', 'amount' => 22000],
            ['type' => 'packaging', 'amount' => 30000],
            ['type' => 'utilities', 'amount' => 18000],
        ] as $expense) {
            $expenseService->addExpense([
                'production_batch_id' => $batch->id,
                'type' => $expense['type'],
                'amount' => $expense['amount'],
                'description' => 'Demo seed expense',
            ]);
        }

        /** @var SalesService $salesService */
        $salesService = app(SalesService::class);

        $salesService->createSale([
            'invoice_number' => 'INV-' . now()->format('Ymd-His'),
            'customer_name' => 'Hoga Distributor Ltd',
            'customer_phone' => '+250788999999',
            'customer_address' => 'Kigali Industrial Zone',
            'location_id' => $location->id,
            'payment_method' => 'mobile_money',
            'delivery_status' => 'delivered',
            'sale_date' => now()->subDay()->toDateString(),
            'items' => [
                [
                    'product_id' => $product->id,
                    'product_package_id' => $package->id,
                    'production_batch_id' => $batch->id,
                    'quantity' => 300,
                    'price' => 980,
                ],
            ],
        ]);
    }
}
