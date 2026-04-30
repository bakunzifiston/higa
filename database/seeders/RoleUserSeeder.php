<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Collection Officer
        DB::table('users')->insert([
            'name' => 'Collection Officer 1',
            'email' => 'collection1@higa.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Production Manager
        DB::table('users')->insert([
            'name' => 'Production Manager 1',
            'email' => 'production1@higa.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Sales Team
        DB::table('users')->insert([
            'name' => 'Sales Team 1',
            'email' => 'sales1@higa.com',
            'password' => Hash::make('password'),
            'role_id' => 4,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update admin to role 1
        DB::table('users')->where('email', 'admin@higaagri.co.zm')->update(['role_id' => 1]);
    }
}
