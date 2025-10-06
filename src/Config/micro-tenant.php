<?php

use Projects\Hq\Contracts\Supports\ConnectionManager;
use Stancl\Tenancy\TenantDatabaseManagers\PostgreSQLSchemaManager;

return [
    'database' => [
        'connection_manager' => ConnectionManager::class,
        'connections' => [
            //THIS SETUP DEFAULT FOR MYSQL
            'central_connection' => [
                'driver'         => env('DB_DRIVER', 'pgsql'),
                'read' => [
                    'host' => [
                        env('DB_READ_HOST_1','192.168.1.1'),
                        env('DB_READ_HOST_2','192.168.1.2')
                    ],
                ],
                'write' => [
                    'host' => [
                        env('DB_WRITE_HOST_1','192.168.1.3')
                    ],
                ],
                'url'            => env('DB_URL'),
                'host'           => env('DB_HOST', '127.0.0.1'),
                'port'           => env('DB_PORT', '3306'),
                'database'       => env('DB_DATABASE', 'wellmed'),
                'username'       => env('DB_USERNAME', 'root'),
                'password'       => env('DB_PASSWORD', ''),
                'charset'        => env('DB_CHARSET', 'utf8'),
                'prefix'         => '',
                'prefix_indexes' => true,
                'search_path'    => 'public',
                'sslmode'        => 'prefer',
            ],
            'tenant' => [
                'driver'         => env('DB_DRIVER', 'pgsql'),
                'read' => [
                    'host' => [
                        env('DB_READ_HOST_1','192.168.1.1'),
                        env('DB_READ_HOST_2','192.168.1.2')
                    ],
                ],
                'write' => [
                    'host' => [
                        env('DB_WRITE_HOST_1','192.168.1.3')
                    ],
                ],
                'url'            => env('DB_URL'),
                'host'           => env('DB_HOST', '127.0.0.1'),
                'port'           => env('DB_PORT', '3306'),
                'database'       => env('DB_DATABASE', 'wellmed'),
                'username'       => env('DB_USERNAME', 'root'),
                'password'       => env('DB_PASSWORD', ''),
                'charset'        => env('DB_CHARSET', 'utf8'),
                'prefix'         => '',
                'prefix_indexes' => true,
                'search_path'    => 'public',
                'sslmode'        => 'prefer',
            ]
        ],
        'managers' => [
            // 'sqlite' => Stancl\Tenancy\TenantDatabaseManagers\SQLiteDatabaseManager::class,
            // 'mysql' => Stancl\Tenancy\TenantDatabaseManagers\MySQLDatabaseManager::class,
            // 'pgsql'  => Stancl\Tenancy\TenantDatabaseManagers\PostgreSQLDatabaseManager::class,

            /**
             * Use this database manager for MySQL to have a DB user created for each tenant database.
             * You can customize the grants given to these users by changing the $grants property.
             */
            // 'mysql' => Stancl\Tenancy\TenantDatabaseManagers\PermissionControlledMySQLDatabaseManager::class,

            /**
         * Disable the pgsql manager above, and enable the one below if you
         * want to separate tenant DBs by schemas rather than databases.
         */
            'pgsql' => PostgreSQLSchemaManager::class, // Separate by schema instead of database
        ],
        'app_tenant'   => [
            'prefix' => 'hq_',
            'suffix' => ''
        ],
        'model_connections' => [
            'central'        => [
                'models' => [
                    'ApiAccess',
                    'Cache',
                    'CacheLock',
                    'Country',
                    'District',
                    'Domain',
                    'FailedJob',
                    'JobBatch',
                    'Job',
                    'PasswordResetToken',
                    'PayloadMonitoring',
                    'PersonalAccessToken',
                    'Province',
                    'Subdistrict',
                    'Tenant',
                    'UserReference',
                    'User',
                    'Village',
                    'Workspace',
                    'CentralUnicode',
                    'Encoding',
                    'MasterFeature',
                    'ModelHasFeature',
                    'Version',
                    'Address'
                ]
            ],
            'tenant' => [
                'models' => [
                    'Unicode',
                    'HqAddress'
                ]
            ]
        ],
        'database_tenant_name' => [
            'prefix' => 'hq_',
            'suffix' => ''
        ],
    ],
];