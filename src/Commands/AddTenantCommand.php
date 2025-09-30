<?php

namespace Projects\Hq\Commands;

use Hanafalah\MicroTenant\Commands\AddTenantCommand as CommandsAddTenantCommand;

class AddTenantCommand extends CommandsAddTenantCommand
{
    protected $signature = 'hq:add-tenant 
                            {--project_name= : Nama project}
                            {--group_name= : Nama group}
                            {--tenant_name= : Nama tenant}';
}