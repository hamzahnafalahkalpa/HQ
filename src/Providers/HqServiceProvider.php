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

                if (isset(request()->product_service_id)){
                    $workspace = $this->WorkspaceModel()->findOrFail(request()->product_service_id);
                    config([
                        'database.connections.clinic.database' => $workspace->tenant->tenancy_db_name
                    ]);
                }

                $this->initializeRabbitMQQueues();

                $this->app->singleton(PathRegistry::class, function () {
                    $registry = new PathRegistry();
        
                    $config = config("hq");
                    foreach ($config['libs'] as $key => $lib) $registry->set($key, 'projects'.$lib);
                    return $registry;
                });
            } catch (\Throwable $th) {
                \Log::error('Hq boot error: ' . $th->getMessage(), [
                    'exception' => $th,
                    'trace' => $th->getTraceAsString()
                ]);
            }
        });
    }

    /**
     * Initialize RabbitMQ queues with proper connection handling
     *
     * NOTE: This only runs once during initial boot, not on every Octane request.
     * The laravel-queue-rabbitmq package also auto-declares queues when workers start.
     *
     * @return void
     */
    protected function initializeRabbitMQQueues(): void
    {
        // Skip if disabled via config
        if (!env('RABBITMQ_DECLARE_QUEUES_ON_BOOT', false)) {
            return;
        }

        // Skip if running in Octane worker (queues already declared on initial boot)
        if (app()->bound('octane.cacheTable')) {
            return;
        }

        // Skip if running in queue worker context
        if (app()->runningInConsole() && str_contains(implode(' ', $_SERVER['argv'] ?? []), 'queue:work')) {
            return;
        }

        $maxRetries = 3;
        $retryDelay = 2; // seconds

        // Heartbeat value - read/write timeout must be at least 2x this
        $heartbeat = (int) env('RABBITMQ_HEARTBEAT', 60);
        $connectionTimeout = (float) env('RABBITMQ_CONNECTION_TIMEOUT', 10.0);
        // Read/write timeout must be > 2 * heartbeat to avoid channel closed errors
        $readWriteTimeout = (float) env('RABBITMQ_READ_WRITE_TIMEOUT', max(130.0, $heartbeat * 2 + 10));

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            $connection = null;
            $channel = null;

            try {
                // Create connection with proper timeout configuration
                $connection = new AMQPStreamConnection(
                    env('RABBITMQ_HOST', '127.0.0.1'),
                    (int) env('RABBITMQ_PORT', 5672),
                    env('RABBITMQ_USER', 'guest'),
                    env('RABBITMQ_PASSWORD', 'guest'),
                    env('RABBITMQ_VHOST', '/'),
                    false, // insist
                    'AMQPLAIN', // login method
                    null, // login response
                    'en_US', // locale
                    $connectionTimeout,
                    $readWriteTimeout,
                    null, // context
                    (bool) env('RABBITMQ_KEEPALIVE', false),
                    $heartbeat
                );

                $channel = $connection->channel();

                // Declare queues (idempotent operation)
                $queues = ['default', 'billing'];
                foreach ($queues as $queue) {
                    $channel->queue_declare($queue, false, true, false, false);
                }

                // Success - close connections and return
                if ($channel && $channel->is_open()) {
                    $channel->close();
                }
                if ($connection && $connection->isConnected()) {
                    $connection->close();
                }

                if ($attempt > 1) {
                    \Log::info("RabbitMQ queue initialization succeeded on attempt {$attempt}");
                }

                return;

            } catch (\PhpAmqpLib\Exception\AMQPHeartbeatMissedException $e) {
                \Log::warning("RabbitMQ heartbeat missed on attempt {$attempt}/{$maxRetries}: {$e->getMessage()}");
                $this->cleanupRabbitMQConnection($channel, $connection);

            } catch (\PhpAmqpLib\Exception\AMQPChannelClosedException $e) {
                \Log::warning("RabbitMQ channel closed on attempt {$attempt}/{$maxRetries}: {$e->getMessage()}");
                $this->cleanupRabbitMQConnection($channel, $connection);

            } catch (\PhpAmqpLib\Exception\AMQPConnectionClosedException $e) {
                \Log::warning("RabbitMQ connection closed on attempt {$attempt}/{$maxRetries}: {$e->getMessage()}");
                $this->cleanupRabbitMQConnection($channel, $connection);

            } catch (\Throwable $e) {
                \Log::warning("RabbitMQ initialization error on attempt {$attempt}/{$maxRetries}: {$e->getMessage()}");
                $this->cleanupRabbitMQConnection($channel, $connection);
            }

            // Retry with exponential backoff (but don't throw on final failure - just log)
            if ($attempt < $maxRetries) {
                sleep($retryDelay * $attempt);
            } else {
                \Log::error("RabbitMQ queue initialization failed after {$maxRetries} attempts. Queues will be declared by workers.");
            }
        }
    }

    /**
     * Safely cleanup RabbitMQ channel and connection
     *
     * @param mixed $channel
     * @param mixed $connection
     * @return void
     */
    protected function cleanupRabbitMQConnection($channel, $connection): void
    {
        try {
            if ($channel && $channel->is_open()) {
                $channel->close();
            }
        } catch (\Throwable $e) {
            \Log::debug("Error closing RabbitMQ channel: {$e->getMessage()}");
        }

        try {
            if ($connection && $connection->isConnected()) {
                $connection->close();
            }
        } catch (\Throwable $e) {
            \Log::debug("Error closing RabbitMQ connection: {$e->getMessage()}");
        }
    }
}
