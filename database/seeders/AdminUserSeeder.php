<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@higaagri.co.zm'],
            [
                'name' => 'Higa AgriBusiness Admin',
                'password' => Hash::make('Higa@2026'),
            ]
        );
    }
}
