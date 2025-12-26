<?php

namespace Projects\Hq\Models\MicroTenant;

use Hanafalah\MicroTenant\Models\Tenant\Tenant as TenantTenant;
use Projects\Hq\Transformers\Tenant\ShowTenant;
use Projects\Hq\Transformers\Tenant\ViewTenant;

class Tenant extends TenantTenant
{
    public function getShowResource(){
        return ShowTenant::class;
    }

    public function getViewResource(){
        return ViewTenant::class;
    }
}
