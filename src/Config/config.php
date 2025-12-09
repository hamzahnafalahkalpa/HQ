<?php

use Projects\Hq\{
    Contracts, Models, Commands
};

return [
    "namespace"     => "Projects\\Hq",
    "service_name"  => "Hq",
    "paths"         => [
        "local_path"   => 'projects',
        "base_path"    => __DIR__.'/../'
    ],
    'backbone' => [
        'url' => env('HQ_BACKBONE_URL', 'http://host.docker.internal:9003/api/add-tenant'),
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
        Commands\SeedCommand::class,
        Commands\GenerateBillingCommand::class
    ],
    "encodings" => [
    ],
    "provider" => "Projects\Hq\\Providers\\HqServiceProvider",
    'packages' => [
        'hanafalah/laravel-feature'             => ['repository' =>'hamzahnafalahkalpa/laravel-feature','provider' => 'Hanafalah\\LaravelFeature\\LaravelFeatureServiceProvider'],
        'hanafalah/module-user'                 => ['repository' =>'hamzahnafalahkalpa/module-user','provider' => 'Hanafalah\\ModuleUser\\ModuleUserServiceProvider'],
        'hanafalah/module-workspace'            => ['repository' =>'hamzahnafalahkalpa/module-workspace','provider' => 'Hanafalah\\ModuleWorkspace\\ModuleWorkspaceServiceProvider'],
        'hanafalah/module-payment'              => ['repository' =>'hamzahnafalahkalpa/module-payment','provider' => 'Hanafalah\\ModulePayment\\ModulePaymentServiceProvider'],
        'hanafalah/module-people'               => ['repository' =>'hamzahnafalahkalpa/module-people','provider' => 'Hanafalah\\ModulePeople\\ModulePeopleServiceProvider'],
        'hanafalah/module-card-identity'        => ['repository' =>'hamzahnafalahkalpa/module-card-identity','provider' => 'Hanafalah\\ModuleCardIdentity\\ModuleCardIdentityServiceProvider'],
        'hanafalah/module-regional'             => ['repository' =>'hamzahnafalahkalpa/module-regional','provider' => 'Hanafalah\\ModuleRegional\\ModuleRegionalServiceProvider'],
        'hanafalah/module-medic-service'        => ['repository' =>'hamzahnafalahkalpa/module-medic-service','provider' => 'Hanafalah\\ModuleMedicService\\ModuleMedicServiceServiceProvider'],
        'hanafalah/module-service'              => ['repository' =>'hamzahnafalahkalpa/module-service','provider' => 'Hanafalah\\ModuleService\\ModuleServiceServiceProvider'],
        'hanafalah/module-support'              => ['repository' =>'hamzahnafalahkalpa/module-support','provider' => 'Hanafalah\\ModuleSupport\\ModuleSupportServiceProvider'],
        'hanafalah/module-transaction'          => ['repository' =>'hamzahnafalahkalpa/module-transaction','provider' => 'Hanafalah\\ModuleTransaction\\ModuleTransactionServiceProvider'],
        'hanafalah/module-tax'                  => ['repository' =>'hamzahnafalahkalpa/module-tax','provider' => 'Hanafalah\\ModuleTax\\ModuleTaxServiceProvider'],
        'hanafalah/wellmed-feature'             => ['repository' =>'hamzahnafalahkalpa/wellmed-feature','provider' => 'Hanafalah\\WellmedFeature\\WellmedFeatureServiceProvider'],
        'hanafalah/module-payer'                => ['repository' =>'hamzahnafalahkalpa/module-payer','provider' => 'Hanafalah\\ModulePayer\\ModulePayerServiceProvider'],
        'hanafalah/module-profession'           => ['repository' =>'hamzahnafalahkalpa/module-profession','provider' => 'Hanafalah\\ModuleProfession\\ModuleProfessionServiceProvider'],
        'hanafalah/module-organization'         => ['repository' =>'hamzahnafalahkalpa/module-organization','provider' => 'Hanafalah\\ModuleOrganization\\ModuleOrganizationServiceProvider'],
        'hanafalah/module-employee'             => ['repository' =>'hamzahnafalahkalpa/module-employee','provider' => 'Hanafalah\\ModuleEmployee\\ModuleEmployeeServiceProvider'],
        'hanafalah/laravel-xendit'              => ['repository' =>'hamzahnafalahkalpa/laravel-xendit','provider' => 'Hanafalah\\LaravelXendit\\LaravelXenditServiceProvider'],
        'hanafalah/module-license'              => ['repository' =>'hamzahnafalahkalpa/module-license','provider' => 'Hanafalah\\ModuleLicense\\ModuleLicenseServiceProvider'],
        'hanafalah/module-employee'             => ['repository' =>'hamzahnafalahkalpa/module-employee','provider' => 'Hanafalah\\ModuleEmployee\\ModuleEmployeeServiceProvider'],
    ]
];
