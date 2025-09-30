<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelPermission\Models\Permission\Permission;

class HqPermission extends Permission
{
    protected $table = 'permissions';

    public function getForeignKey(){
        return 'permission_id';
    }
}
