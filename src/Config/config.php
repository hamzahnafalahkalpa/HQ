<?php

use Projects\Hq\{
    Contracts, Models, Commands
};

return [
    "namespace"     => "Projects\Hq",
    "service_name"  => "Hq",
    "paths"         => [
        "local_path"   => 'projects',
        "base_path"    => __DIR__.'\\..\\'
    ],
    "libs"           => [
        'migration' => 'Database/Migrations',
        'database' => 'Database',
        'model' => 'Models',
        'controller' => 'Controllers',
        'provider' => 'Providers',
        'contract' => 'Contracts',
        'concern' => 'Concerns',
        'command' => 'Commands',
        'route' => 'Routes',
        'observer' => 'Observers',
        'policy' => 'Policies',
        'transformer' => 'Transformers',
        'seeder' => 'Database/Seeders',
        'middleware' => 'Middleware',
        'request' => 'Requests',
        'support' => 'Supports',
        'view' => 'Views',
        'schema' => 'Schemas',
        'facade' => 'Facades',
        'config' => 'Config',
        'import' => 'Imports',
        'data' => 'Data',
        'resource' => 'Resources',
    ],
    "packages" => [
        /*--------------------------------------------------------------------------
        * Note: The contents of the packages are started with the class base name,
        * then followed by config and others. You can be used to override default package config
        * "module-user" => [
        *       "config" => []
        * ]
        *------------------------------------------------------------------------*/
    ],
    "app" => [
        "impersonate" => [
            "storage"   => [
                "driver" => env("FILESYSTEM_DISK", 'local'),
            ],
        ],
        "contracts" => [
        ],
    ],
    "database"     => [
        "models"   => [
        ]
    ],
    "commands" => [
        Commands\AddTenantCommand::class,
        Commands\GenerateCommand::class,
        Commands\ImpersonateCacheCommand::class,
        Commands\ImpersonateMigrateCommand::class,
        Commands\InstallMakeCommand::class,
        Commands\MigrateCommand::class,
        Commands\ModelMakeCommand::class,
        Commands\SeedCommand::class
    ],
    "encodings" => [
    ],
    "provider" => "Projects\Hq\\Providers\\HqServiceProvider",
    'packages' => [
        'hanafalah/laravel-feature'             => ['repository' =>'hamzahnafalahkalpa/laravel-feature'],
        'hanafalah/module-user'                 => ['repository' =>'hamzahnafalahkalpa/module-user'],
        'hanafalah/module-workspace'            => ['repository' =>'hamzahnafalahkalpa/module-workspace'],
        'hanafalah/module-payment'              => ['repository' =>'hamzahnafalahkalpa/module-payment'],
        'hanafalah/module-people'               => ['repository' =>'hamzahnafalahkalpa/module-people'],
        'hanafalah/module-card-identity'        => ['repository' =>'hamzahnafalahkalpa/module-card-identity'],
        'hanafalah/module-regional'             => ['repository' =>'hamzahnafalahkalpa/module-regional'],
        'hanafalah/module-service'              => ['repository' =>'hamzahnafalahkalpa/module-service'],
        'hanafalah/module-support'              => ['repository' =>'hamzahnafalahkalpa/module-support'],
        'hanafalah/module-transaction'          => ['repository' =>'hamzahnafalahkalpa/module-transaction'],
        'hanafalah/module-tax'                  => ['repository' =>'hamzahnafalahkalpa/module-tax'],
        'hanafalah/wellmed-feature'             => ['repository' =>'hamzahnafalahkalpa/wellmed-feature']
    ]
];
