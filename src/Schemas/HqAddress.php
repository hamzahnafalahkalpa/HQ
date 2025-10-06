<?php

namespace Projects\Hq\Schemas;

use Projects\Hq\Contracts\Schemas\HqAddress as ContractsHqAddress;
use Hanafalah\ModuleRegional\Schemas\Regional\Address;

class HqAddress extends Address implements ContractsHqAddress
{
    protected string $__entity = 'HqAddress';
    public $hq_address_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'hq_address',
            'tags'     => ['hq_address', 'hq_address-index'],
            'duration' => 24 * 60
        ]
    ];
}