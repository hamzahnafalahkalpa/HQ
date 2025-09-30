<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelPermission\Models\Role\Role;

class HqRole extends Role
{
    protected $table = 'roles';

    public function getForeignKey(){
        return 'role_id';
    }
}
