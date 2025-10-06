<?php

use Hanafalah\LaravelPermission\Enums\Permission\Type;

return [
    'name'        => 'Pendaftaran Wellmed',
    'alias'       => 'submission',
    'icon'        => 'carbon:application',
    'type'        => Type::MENU->value,
    'show_in_acl' => true,
    'guard_name'  => 'api',
    'childs'      => [
        [
            'name'        => 'Tambah Data Pendaftaran',
            'alias'       => 'store',
            'type'        => Type::PERMISSION->value,
            'guard_name'  => 'api',
            'show_in_acl' => true
        ],
        [
            'name'        => 'Ubah Data Pendaftaran',
            'alias'       => 'update',
            'type'        => Type::PERMISSION->value,
            'guard_name'  => 'api'
        ],
        [
            'name'        => 'Detail Data Pendaftaran',
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
            'name'       => 'Hapus Data Pendaftaran',
            'alias'      => 'destroy',
            'type'       => Type::PERMISSION->value,
            'guard_name' => 'api'
        ]
    ]
];

