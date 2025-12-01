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
        config([
            'laravel-feature.is_validate_restriction' => false,
            'laravel-support.use_id_as_primary_validation_unicode' => false,
            'app.use_license_validation' => false,
            'app.is_seeding' => true
        ]);
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
