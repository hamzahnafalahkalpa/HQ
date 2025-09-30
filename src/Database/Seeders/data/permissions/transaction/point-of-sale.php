<?php

use Hanafalah\LaravelPermission\Enums\Permission\Type;

return [
    'name'        => 'Point of Sale',
    'alias'       => 'point-of-sale',
    'icon'        => 'mdi:network-point-of-sale',
    'type'        => Type::MENU->value,
    'show_in_acl' => true,
    'guard_name'  => 'api',
    'childs'      => [
        [
            'name'        => 'Tambah Data POS',
            'alias'       => 'store',
            'type'        => Type::PERMISSION->value,
            'guard_name'  => 'api',
            'show_in_acl' => true
        ],
        [
            'name'        => 'Ubah Data POS',
            'alias'       => 'update',
            'type'        => Type::PERMISSION->value,
            'guard_name'  => 'api'
        ],
        [
            'name'        => 'Detail Data POS',
            'alias'       => 'show',
            'type'        => Type::PERMISSION->value,
            'guard_name'  => 'api',
            'show_in_data' => true,
            'show_in_acl' => true,
            'childs'      => [
                include_once __DIR__.'/point-of-sale/billing.php',
            ]
        ],
        [
            'name'       => 'Hapus Data POS',
            'alias'      => 'destroy',
            'type'       => Type::PERMISSION->value,
            'guard_name' => 'api'
        ]
    ]
];

