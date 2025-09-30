<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelPermission\Models\Permission\Permission;
use Hanafalah\LaravelPermission\Models\Role\RoleHasPermission;

class HqRoleHasPermission extends RoleHasPermission
{
    protected $table = 'role_has_permissions';

    public function getForeignKey(){
        return 'role_has_permission_id';
    }
}
