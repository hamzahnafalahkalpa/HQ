<?php

namespace Projects\Hq\Providers;

use Illuminate\Foundation\Http\Kernel;
use Hanafalah\LaravelSupport\{
    Concerns\NowYouSeeMe,
    Supports\PathRegistry
};
use Projects\Hq\{
    Hq,
    Contracts,
    Facades
};
use Hanafalah\MicroTenant\Facades\MicroTenant;
use Projects\Hq\Contracts\Supports\ConnectionManager as ConnectionManager;
use Projects\Hq\Supports\ConnectionManager as SupportsConnectionManager;

class HqServiceProvider extends HqEnvironment
{
    use NowYouSeeMe;

    public function register()
    {
        $this->registerMainClass(Hq::class,false)
             ->registerCommandService(CommandServiceProvider::class)
            ->registers([
                'Services' => function(){
                    $this->binds([
                        ConnectionManager::class => SupportsConnectionManager::class
                    ]);   
                },
                'Config' => function() {
                    $this->__config_hq = config('hq');
                },
                'Provider' => function(){
                    $this->registerOverideConfig('hq',__DIR__.'/../'.$this->__config_hq['libs']['config']);
                }
            ]);
    }

    public function boot(Kernel $kernel){    
        $this->registerModel();
        $this->app->booted(function(){
            try {
                $tenant = $this->TenantModel()->where('flag','APP')->where('props->product_type','Hq')->first();  
                if (isset($tenant)) {
                    config(['database.connections.tenant.search_path' => $tenant->tenancy_db_name]);
                    $cache = app(config('laravel-support.service_cache'))->getConfigCache();
                    $this->registers([
                        '*',
                        'Provider' => function() use ($tenant){
                            $this->bootedRegisters($tenant->packages, 'hq', __DIR__.'/../'.$this->__config_hq['libs']['migration'] ?? 'Migrations');
                            $this->registerOverideConfig('hq',__DIR__.'/../'.$this->__config_hq['libs']['config']);
                        },
                        'Model', 'Database',
                    ]);
                    MicroTenant::impersonate($tenant,false);    
                    ($this->checkCacheConfig('config-cache')) ? $this->multipleBinds(config('app.contracts')) : $this->autoBinds();
                    $this->registerRouteService(RouteServiceProvider::class);
                    
                    $this->app->singleton(PathRegistry::class, function () {
                        $registry = new PathRegistry();
            
                        $config = config("hq");
                        foreach ($config['libs'] as $key => $lib) $registry->set($key, 'projects'.$lib);
                        return $registry;
                    });
                }else{
                    $this->registers([
                        '*',
                        'Model', 'Database',
                        'Provider' => function() use ($tenant){
                            $this->registerOverideConfig('hq',__DIR__.'/../'.$this->__config_hq['libs']['config']);
                        }
                    ]);
                    $this->autoBinds();
                }
            } catch (\Exception $e) {
            }
        });
    }    
}
