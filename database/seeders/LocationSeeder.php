<?php

namespace Database\Seeders;

use App\Domain\Inventory\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Kigali Main Warehouse',
                'code' => 'KGL-MAIN',
                'country' => 'Rwanda',
                'province' => 'Kigali City',
                'district' => 'Gasabo',
                'sector' => 'Remera',
                'cell' => 'Nyarutarama',
                'village' => 'Amahoro',
                'is_active' => true,
            ],
            [
                'name' => 'Musanze Processing Store',
                'code' => 'MSZ-PROC',
                'country' => 'Rwanda',
                'province' => 'Northern',
                'district' => 'Musanze',
                'sector' => 'Muhoza',
                'cell' => 'Ruhengeri',
                'village' => 'Inyamibwa',
                'is_active' => true,
            ],
        ];

        foreach ($locations as $location) {
            Location::query()->updateOrCreate(['code' => $location['code']], $location);
        }
    }
}
