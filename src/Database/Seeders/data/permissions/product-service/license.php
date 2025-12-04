<?php

use Hanafalah\LaravelPermission\Enums\Permission\Type;

return [
    'name'        => 'Lisensi Pengguna', 
    'alias'       => 'license',
    'icon'        => 'grommet-icons:license',
    'type'        => Type::MODULE->value,
    'show_in_acl' => true,
    'guard_name'  => 'api',
    'ordering'    => 1,
    'childs'      => [
        [
            'name'        => 'Ubah Layanan',
            'alias'       => 'store',
            'type'        => Type::PERMISSION->value,
            'guard_name'  => 'api'
        ],
        [
            'name'        => 'Detail Lisensi',
            'alias'       => 'show',
            'type'        => Type::PERMISSION->value,
            'guard_name'  => 'api',
            'show_in_data' => true,
            'show_in_acl' => true
        ]
    ]
];

