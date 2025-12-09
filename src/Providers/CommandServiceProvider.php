<?php

namespace Projects\Hq\Providers;

use Illuminate\Support\ServiceProvider;
use Projects\Hq\Commands;

class CommandServiceProvider extends ServiceProvider
{
    protected $__commands = [
        Commands\AddTenantCommand::class,
        Commands\GenerateCommand::class,
        Commands\ImpersonateCacheCommand::class,
        Commands\ImpersonateMigrateCommand::class,
        Commands\InstallMakeCommand::class,
        Commands\MigrateCommand::class,
        Commands\ModelMakeCommand::class,
        Commands\SeedCommand::class,
        Commands\GenerateBillingCommand::class
    ];

    /**
     * Register the command.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(config('hq.commands', $this->__commands));
    }

    public function provides()
    {
        return $this->__commands;
    }
}
