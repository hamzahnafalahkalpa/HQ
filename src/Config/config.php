<?php

use Projects\Hq\{
    Contracts, Models, Commands
};

return [
    "namespace"     => "Projects\Hq",
    "service_name"  => "Hq",
    "paths"         => [
        "local_path"   => 'projects',
        "base_path"    => __DIR__.'/../'
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
        'hanafalah/wellmed-feature'             => ['repository' =>'hamzahnafalahkalpa/wellmed-feature'],
        'hanafalah/module-payer'                => ['repository' =>'hamzahnafalahkalpa/module-payer'],
        'hanafalah/module-profession'           => ['repository' =>'hamzahnafalahkalpa/module-profession'],
        'hanafalah/module-card-identity'        => ['repository' =>'hamzahnafalahkalpa/module-card-identity'],
        'hanafalah/module-organization'         => ['repository' =>'hamzahnafalahkalpa/module-organization'],
        'hanafalah/module-employee'             => ['repository' =>'hamzahnafalahkalpa/module-employee'],
        'hanafalah/laravel-xendit'              => ['repository' =>'hamzahnafalahkalpa/laravel-xendit']
    ]
];
