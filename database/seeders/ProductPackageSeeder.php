<?php

namespace Database\Seeders;

use App\Domain\Inventory\Models\Product;
use App\Domain\Inventory\Models\ProductPackage;
use Illuminate\Database\Seeder;

class ProductPackageSeeder extends Seeder
{
    public function run(): void
    {
        $weights = [5, 10, 25, 100];

        Product::query()->get()->each(function (Product $product) use ($weights) {
            foreach ($weights as $weight) {
                ProductPackage::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'weight_kg' => $weight,
                    ],
                    [
                        'name' => sprintf('%skg pack', $weight),
                        'is_active' => true,
                    ]
                );
            }
        });
    }
}
