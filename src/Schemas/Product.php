<?php

namespace Projects\Hq\Schemas;

use Illuminate\Database\Eloquent\Model;
use Projects\Hq\{
    Supports\BaseHq
};
use Projects\Hq\Contracts\Schemas\Product as ContractsProduct;
use Projects\Hq\Contracts\Data\ProductData;

class Product extends BaseHq implements ContractsProduct
{
    protected string $__entity = 'Product';
    public $product_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'product',
            'tags'     => ['product', 'product-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreProduct(ProductData $product_dto): Model{
        $add = [
            'flag' => $product_dto->flag,
            'name' => $product_dto->name
        ];
        if (isset($product_dto->id)){
            $guard  = ['id' => $product_dto->id];
            $create = [$guard, $add];
        }else{
            $create = [$add];
        }

        $product = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($product,$product_dto->props);
        $product->save();
        return $this->product_model = $product;
    }
}