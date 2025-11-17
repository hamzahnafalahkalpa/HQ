<?php

namespace Projects\Hq\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Hanafalah\ModulePayment\Database\Seeders\WalletSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TimezoneSeeder::class,
            WorkspaceSeeder::class,
            ApiAccessSeeder::class,
            EncodingSeeder::class,
            WalletSeeder::class,
            PermissionSeeder::class,
            TimezoneSeeder::class,
            RoleSeeder::class,
            ProductSeeder::class,
            PaymentMethodSeeder::class,
            UserSeeder::class,
            AssetSeeder::class,
            MedicServiceSeeder::class,
        ]);
    }
}
