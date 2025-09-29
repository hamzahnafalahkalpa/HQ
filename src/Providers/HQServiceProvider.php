<?php

namespace Projects\HQ\Providers;

use Illuminate\Foundation\Http\Kernel;
use Hanafalah\LaravelSupport\{
    Concerns\NowYouSeeMe,
    Supports\PathRegistry
};
use Illuminate\Support\Str;
use Projects\HQ\{
    HQ,
    Contracts,
    Facades
};
use Hanafalah\LaravelSupport\Middlewares\PayloadMonitoring;
use Hanafalah\MicroTenant\Contracts\Supports\ConnectionManager;
use Projects\HQ\Supports\ConnectionManager as SupportsConnectionManager;

class HQServiceProvider extends HQEnvironment
{
    use NowYouSeeMe;

    public function register()
    {
        $this->registerMainClass(HQ::class,false)
             ->registerCommandService(CommandServiceProvider::class)
            ->registers([
                'Services' => function(){
                    $this->binds([
                        Contracts\HQ::class => function(){
                            return new HQ;
                        },
                        ConnectionManager::class => SupportsConnectionManager::class
                        //WorkspaceDTO\WorkspaceSettingData::class => WorkspaceSettingData::class
                    ]);   
                },
                'Config' => function() {
                    $this->__config_h_q = config('h-q');
                },
                'Provider' => function(){
                    $this->registerOverideConfig('h-q',__DIR__.'/../'.$this->__config_h_q['libs']['config']);
                }
            ]);
    }

    public function boot(Kernel $kernel){    
        $tenant = $this->TenantModel()->where('flag','HQ')->first();  
        if (isset($tenant)) {
            $kernel->pushMiddleware(PayloadMonitoring::class);
            tenancy()->initialize(HQ::ID);
            $this->registers([
                '*',
                'Model', 'Database'
            ]);
            $this->autoBinds();
            $this->registerRouteService(RouteServiceProvider::class);
    
            $this->app->singleton(PathRegistry::class, function () {
                $registry = new PathRegistry();
    
                $config = config("h-q");
                foreach ($config['libs'] as $key => $lib) $registry->set($key, 'projects'.$lib);
                return $registry;
            });
        }
    }    
}
