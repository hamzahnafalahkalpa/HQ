<?php

namespace Projects\Hq\Database\Seeders;

use Hanafalah\LaravelPermission\Facades\LaravelPermission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder{
    public function run(): void
    {
        $permissions = LaravelPermission::scanPermissions(__DIR__.'/data/permissions');
        app(config('app.contracts.Permission'))->prepareStorePermission($permissions);
    }
}