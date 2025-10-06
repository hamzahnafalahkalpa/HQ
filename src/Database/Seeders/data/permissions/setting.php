<?php

use Hanafalah\LaravelPermission\Enums\Permission\Type;

return [
    'name'        => 'Pengaturan', 
    'alias'       => 'api.setting',
    'icon'        => 'mdi:cellphone-settings-variant',
    'type'        => Type::MENU->value,
    'show_in_acl' => true,
    'guard_name'  => 'api',
    'ordering'    => 99,
    'childs'      => [
        include __DIR__.'/setting/acl.php',
        include __DIR__.'/setting/general-setting.php'
    ]
];

