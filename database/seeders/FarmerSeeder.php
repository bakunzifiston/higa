<?php

namespace Database\Seeders;

use App\Domain\Suppliers\Models\Farmer;
use Illuminate\Database\Seeder;

class FarmerSeeder extends Seeder
{
    public function run(): void
    {
        $farmers = [
            [
                'name' => 'Jean Bosco',
                'phone' => '+250788000001',
                'country' => 'Rwanda',
                'province' => 'Eastern',
                'district' => 'Kayonza',
                'sector' => 'Mukarange',
                'cell' => 'Nyagatovu',
                'village' => 'Rwimishinya',
            ],
            [
                'name' => 'Claudine Mukamana',
                'phone' => '+250788000002',
                'country' => 'Rwanda',
                'province' => 'Southern',
                'district' => 'Huye',
                'sector' => 'Ngoma',
                'cell' => 'Matyazo',
                'village' => 'Kabeza',
            ],
        ];

        foreach ($farmers as $farmer) {
            Farmer::query()->updateOrCreate(['phone' => $farmer['phone']], $farmer);
        }
    }
}
