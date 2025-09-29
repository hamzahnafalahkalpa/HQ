<?php

namespace Projects\HQ\Database\Seeders;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Hanafalah\MicroTenant\Contracts\Data\TenantData;
use Hanafalah\MicroTenant\Facades\MicroTenant;
use Hanafalah\ModuleRegional\Data\AddressData;
use Hanafalah\ModuleWorkspace\Data\{
    WorkspaceData,
    WorkspacePropsData,
    WorkspaceSettingData
};
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
        $workspace = app(config('database.models.Workspace'))->uuid('9e7ff0f6-7679-46c8-ac3e-71da81816HQ')->first();        
        $generator_config = config('laravel-package-generator');
        $project_namespace = 'Projects';
        if (!isset($workspace)){
            $workspace = app(config('app.contracts.Workspace'))->prepareStoreWorkspace(WorkspaceData::from([
                'uuid'    => '9e7ff0f6-7679-46c8-ac3e-71da818160HQ',
                'name'    => 'HQ',
                'status'  => Status::ACTIVE->value
            ]));

            $tenant_schema  = app(config('app.contracts.Tenant'));
            $tenant_model   = app(config('database.models.Tenant'));
            $project_tenant = $tenant_schema->prepareStoreTenant($this->requestDTO(TenantData::class,[
                'parent_id'      => null,
                'name'           => 'Wellmed Lite',
                'flag'           => $tenant_model::FLAG_APP_TENANT,
                'reference_id'   => null,
                'reference_type' => null,
                'provider'       => $project_namespace.'\\WellmedLite\\Providers\\WellmedLiteServiceProvider',
                'path'           => $generator_config['patterns']['project']['published_at'],
                'packages'       => [],
                'config'         => $generator_config['patterns']['project']
            ]));
            dd($project_tenant);
        }else{
            $project_tenant = $workspace->tenant;
        }

        $providers = config('wellmed-lite-starterpack.packages');
        $providers = array_keys($providers);
        $package_providers = [];
        $requires = [
            'require' => []
        ];
        $repositories = [
            'repositories' => []
        ];
        foreach ($providers as $provider) {
            $original    = $provider;
            $provider    = explode("/", $provider);
            $provider[0] = Str::studly($provider[0]);
            $provider[1] = Str::studly($provider[1]);
            $provider    = implode('\\',$provider).'\\'.$provider[1].'ServiceProvider';
            $package_providers[$original] = [
                'provider' => $provider
            ];

            $repositories['repositories'][Str::kebab($original)] = [
                'type' => 'path',
                'url'  => '../../repositories/'.Str::afterLast($original,'/'),
                'options' => [
                    'symlink' => true
                ]
            ];
            if (Str::kebab($original) != 'hanafalah/microtenant'){
                $requires['require'][Str::kebab($original)] = 'dev-main as 1.0'; 
            }
        }
        
        $project_tenant->setAttribute('packages',$package_providers);
        $project_tenant->save();
        // shell_exec("cd $tenant_path/".Str::kebab($tenant->name)." && rm -rf composer.lock && composer install");
        MicroTenant::tenantImpersonate($project_tenant);
        tenancy()->initialize($project_tenant->getKey());

        // Artisan::call('impersonate:cache',[
        //     '--app_id'    => $project_tenant->getKey()
        // ]);

        Artisan::call('impersonate:migrate',[
            '--app'       => true,
            '--app_id'    => $project_tenant->getKey()
        ]);
    }
}