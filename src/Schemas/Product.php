<?php

namespace Projects\Hq\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\Product as ContractsProduct;
use Projects\Hq\Contracts\Data\ProductData;

class Product extends Unicode implements ContractsProduct
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
        $product = $this->prepareStoreUnicode($product_dto);

        if (isset($product_dto->product_items)){
            foreach ($product_dto->product_items as &$product_item_dto) {
                $product_item_dto->product_id = $product->getKey();
                $this->schemaContract('product_item')->prepareStoreProductItem($product_item_dto);
            }
        }

        $this->fillingProps($product,$product_dto->props);
        $product->save();
        return $this->product_model = $product;
    }

    public function product(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}