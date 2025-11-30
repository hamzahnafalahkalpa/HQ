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
};
use Hanafalah\MicroTenant\Facades\MicroTenant;
use Projects\Hq\Contracts\Schemas\ModuleWorkspace\Workspace;
use Projects\Hq\Contracts\Schemas\Product;
use Projects\Hq\Contracts\Supports\ConnectionManager as ConnectionManager;
use Projects\Hq\Schemas\Product as SchemasProduct;
use Projects\Hq\Schemas\ModuleWorkspace\Workspace as SchemasWorkspace;
use Projects\Hq\Supports\ConnectionManager as SupportsConnectionManager;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class HqServiceProvider extends HqEnvironment
{
    use NowYouSeeMe;

    public function register()
    {
        $this->registerMainClass(Hq::class)
             ->registerCommandService(CommandServiceProvider::class)
            ->registers([
                '*',
                'Services' => function(){
                    $this->binds([
                        Contracts\Hq::class => function(){
                            return new Hq;
                        },
                        ConnectionManager::class => SupportsConnectionManager::class,
                        Workspace::class => SchemasWorkspace::class,
                        Product::class => SchemasProduct::class
                    ]);   
                },
                'Config' => function() {
                    $this->__config_hq = config('hq');
                },
                'Provider' => function(){
                    $this->bootedRegisters($this->__config_hq['packages'], 'hq');
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
                    $cache = app(config('laravel-support.service_cache'))->getConfigCache();

                    $this->registers([
                        'Provider' => function(){
                            $this->bootedRegisters($this->__config_hq['packages'], 'hq', __DIR__.'/../'.$this->__config_hq['libs']['migration'] ?? 'Migrations');
                            $this->registerOverideConfig('hq',__DIR__.'/../'.$this->__config_hq['libs']['config']);
                        }
                    ]);

                    MicroTenant::impersonate($tenant,false);    
                    ($this->checkCacheConfig('config-cache')) ? $this->multipleBinds(config('app.contracts')) : $this->autoBinds();
                    $this->registerRouteService(RouteServiceProvider::class);
                    
                }

                $connection = new AMQPStreamConnection(
                    env('RABBITMQ_HOST'),
                    env('RABBITMQ_PORT'),
                    env('RABBITMQ_USER'),
                    env('RABBITMQ_PASSWORD'),
                    '/'
                );

                $channel = $connection->channel();

                foreach (['default', 'billing'] as $queue) {
                    $channel->queue_declare($queue, false, true, false, false);
                }

                $channel->close();
                $connection->close();

                $this->app->singleton(PathRegistry::class, function () {
                    $registry = new PathRegistry();
        
                    $config = config("hq");
                    foreach ($config['libs'] as $key => $lib) $registry->set($key, 'projects'.$lib);
                    return $registry;
                });
            } catch (\Throwable $th) {
            }
        });
    }    
}
