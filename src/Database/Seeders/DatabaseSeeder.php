<?php

namespace Projects\Hq\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            WorkspaceSeeder::class,
            ApiAccessSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            ProductSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
