<?php

namespace Projects\Hq\Commands;

use Hanafalah\MicroTenant\Commands\Impersonate\ImpersonateMigrateCommand as ImpersonateImpersonateMigrateCommand;

class ImpersonateMigrateCommand extends ImpersonateImpersonateMigrateCommand
{
    protected $signature = 'hq:impersonate-migrate 
                                {--app= : The type of the application}
                                {--group= : The type of the group}
                                {--tenant= : The type of the tenant}
                                {--app_id= : The id of the application}
                                {--group_id= : The id of the group}
                                {--tenant_id= : The id of the tenant}
                            ';
}