<?php

use Hanafalah\LaravelPermission\Enums\Permission\Type;

return [
    'name'        => 'Customer Care', 
    'alias'       => 'api.customer-care',
    'icon'        => 'ix:customer-filled',
    'type'        => Type::MENU->value,
    'show_in_acl' => true,
    'guard_name'  => 'api',
    'ordering'    => 1
];

