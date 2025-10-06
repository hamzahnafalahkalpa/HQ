<?php

namespace Projects\Hq\Database\Seeders;

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
        $workspace = app(config('database.models.Workspace'))->uuid('9e7ff0f6-7679-46c8-ac3e-71da818160Hq')->first();        
        $generator_config = config('laravel-package-generator');
        $project_namespace = 'Projects';
        if (!isset($workspace)){
            $is_new = true;
            $workspace = app(config('app.contracts.Workspace'))->prepareStoreWorkspace(WorkspaceData::from([
                'uuid'    => '9e7ff0f6-7679-46c8-ac3e-71da818160Hq',
                'name'    => 'Hq',
                'status'  => Status::ACTIVE->value
            ]));

            $tenant_schema  = app(config('app.contracts.Tenant'));
            $project_tenant = $tenant_schema->prepareStoreTenant($this->requestDTO(TenantData::class,[
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
        if ($is_new){
            $providers = config('hq.packages',[]);
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
        }
        MicroTenant::tenantImpersonate($project_tenant);
        tenancy()->initialize($project_tenant);

        Artisan::call('impersonate:cache',[
            '--app_id'    => $project_tenant->getKey()
        ]);

        Artisan::call('impersonate:migrate',[
            '--app'       => true,
            '--app_id'    => $project_tenant->getKey()
        ]);
    }
}