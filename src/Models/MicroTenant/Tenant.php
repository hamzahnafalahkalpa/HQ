<?php

namespace Projects\Hq\Models\MicroTenant;

use Hanafalah\MicroTenant\Models\Tenant\Tenant as TenantTenant;
use Projects\Hq\Resources\Tenant\ShowTenant;
use Projects\Hq\Resources\Tenant\ViewTenant;

class Tenant extends TenantTenant
{
    public function getShowResource(){
        return ShowTenant::class;
    }

    public function getViewResource(){
        return ViewTenant::class;
    }
}
