<?php

namespace Projects\Hq\Commands;

use Hanafalah\LaravelSupport\Concerns\ServiceProvider\HasMigrationConfiguration;
use Hanafalah\MicroTenant\Facades\MicroTenant;

class EnvironmentCommand extends \Hanafalah\LaravelSupport\Commands\BaseCommand
{
    use HasMigrationConfiguration;
    
    protected function init(): self
    {
        MicroTenant::tenantImpersonate(app(config('database.models.Tenant'))->where('props->product_type','Hq')->firstOrFail());
        return $this;
    }

    protected function dir(): string
    {
        return __DIR__ . '/../';
    }

}
