<?php

namespace Projects\Hq\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\ProductItem as ContractsProductItem;
use Projects\Hq\Contracts\Data\ProductItemData;

class ProductItem extends PackageManagement implements ContractsProductItem
{
    protected string $__entity = 'ProductItem';
    public $product_item_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'product_item',
            'tags'     => ['product_item', 'product_item-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreProductItem(ProductItemData $product_item_dto): Model{
        if (isset($product_item_dto->master_product_item)){
            $master_product_item = $this->schemaContract('master_product_item')->prepareStoreMasterProductItem($product_item_dto->master_product_item);
            $product_item_dto->master_product_item_id = $master_product_item->getKey();
        }

        $add = [
            'name' => $product_item_dto->name,
            'price' => $product_item_dto->price
        ];
        if (isset($product_item_dto->id)) {
            $guard  = ['id' => $product_item_dto->id];
        }else{
            $guard = [
                'product_id' => $product_item_dto->product_id,
                'master_product_item_id' => $product_item_dto->master_product_item_id
            ];
        }
        $create = [$guard, $add];
        $product_item = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($product_item,$product_item_dto->props);
        $product_item->save();
        return $this->product_item_model = $product_item;
    }
}