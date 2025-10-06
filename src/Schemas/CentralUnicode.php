<?php

namespace Projects\Hq\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\CentralUnicode as ContractsCentralUnicode;
use Projects\Hq\Contracts\Data\CentralUnicodeData;

class CentralUnicode extends Unicode implements ContractsCentralUnicode
{
    protected string $__entity = 'CentralUnicode';
    public $central_unicode_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'central_unicode',
            'tags'     => ['central_unicode', 'central_unicode-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreCentralUnicode(CentralUnicodeData $central_unicode_dto): Model{
        $central_unicode = $this->prepareStoreUnicode($central_unicode_dto);
        return $this->central_unicode_model = $central_unicode;
    }

    public function centralUnicode(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}