<?php

namespace Projects\Hq\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\MasterProductItem as ContractsMasterProductItem;
use Projects\Hq\Contracts\Data\MasterProductItemData;

class MasterProductItem extends Unicode implements ContractsMasterProductItem
{
    protected string $__entity = 'MasterProductItem';
    public $master_product_item_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'master_product_item',
            'tags'     => ['master_product_item', 'master_product_item-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreMasterProductItem(MasterProductItemData $master_product_item_dto): Model{
        $master_product_item = $this->prepareStoreUnicode($master_product_item_dto);
        return $this->master_product_item_model = $master_product_item;
    }

    public function masterProductItem(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}