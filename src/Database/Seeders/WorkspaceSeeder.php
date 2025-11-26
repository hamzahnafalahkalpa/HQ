<?php

namespace Projects\Hq\Database\Seeders;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Hanafalah\MicroTenant\Contracts\Data\TenantData;
use Hanafalah\MicroTenant\Facades\MicroTenant;
use Hanafalah\ModuleWorkspace\Enums\Workspace\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class WorkspaceSeeder extends Seeder{
    use HasRequestData;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $workspace = app(config('database.models.Workspace'))->uuid('9e7ff0f6-7679-46c8-ac3e-71da818160Hq')->first();        
        $generator_config = config('laravel-package-generator');
        $project_namespace = 'Projects';
        if (!isset($workspace)){
            $is_new = true;
            $workspace = app(config('app.contracts.Workspace'))->prepareStoreWorkspace($this->requestDTO(config('app.contracts.WorkspaceData'),[
                'uuid'    => '9e7ff0f6-7679-46c8-ac3e-71da818160Hq',
                'name'    => 'Hq',
                'status'  => Status::ACTIVE->value
            ]));

            $tenant_schema  = app(config('app.contracts.Tenant'));
            $project_tenant = $tenant_schema->prepareStoreTenant($this->requestDTO(config('app.contracts.TenantData'),[
                'parent_id'      => null,
                'name'           => 'Hq',
                'flag'           => 'APP',
                'reference_id'   => $workspace->getKey(),
                'reference_type' => $workspace->getMorphClass(),
                'provider'       => $project_namespace.'\\Hq\\Providers\\HqServiceProvider',
                'path'           => $generator_config['patterns']['project']['published_at'],
                'packages'       => [],
                'product_type'   => 'Hq',
                'config'         => $generator_config['patterns']['project']
            ]));
        }else{
            $is_new = false;
            $project_tenant = $workspace->tenant;
        }

        config([
            'database.connections.tenant.search_path' => $project_tenant->tenancy_db_name
        ]);

        Artisan::call('impersonate:cache',[
            '--app_id'    => $project_tenant->getKey()
        ]);

        Artisan::call('impersonate:migrate',[
            '--app'       => true,
            '--app_id'    => $project_tenant->getKey()
        ]);

        MicroTenant::tenantImpersonate($project_tenant,false);        

        $transaction = app(config('app.contracts.Transaction'))
            ->prepareStoreTransaction($this->requestDTO(config('app.contracts.TransactionData'),[
                'reference_model' => $workspace,
                'reference_id' => $workspace->getKey(),
                'reference_type' => $workspace->getMorphClass()
            ]));
        $workspace->prop_transaction = $transaction->toViewApi()->resolve();
        $workspace->save();
    }
}