<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Collection Officer', 'slug' => 'collection-officer'],
            ['name' => 'Production Manager', 'slug' => 'production-manager'],
            ['name' => 'Sales Team', 'slug' => 'sales-team'],
        ];

        DB::table('roles')->insert($roles);
    }
}
