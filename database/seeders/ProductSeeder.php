<?php

namespace Database\Seeders;

use App\Domain\Inventory\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Kawunga', 'sku' => 'KAWUNGA'],
            ['name' => 'Blanda', 'sku' => 'BLANDA'],
            ['name' => 'Animal Feed', 'sku' => 'ANIMAL-FEED'],
        ];

        foreach ($products as $payload) {
            Product::query()->updateOrCreate(
                ['sku' => $payload['sku']],
                ['name' => $payload['name'], 'is_active' => true]
            );
        }
    }
}
