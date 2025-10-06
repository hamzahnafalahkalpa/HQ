<?php

use Hanafalah\ModuleUser\{
    Commands as ModuleUserCommands,
};

return [
    'user_reference_types' => [
        'company' => [
            'schema' => 'Company',
        ],
        'employee' => [
            'schema' => 'Employee',
        ],
        'people' => [
            'schema' => 'People',
        ]
    ],
];
