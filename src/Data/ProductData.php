<?php

namespace Projects\Hq\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Projects\Hq\Contracts\Data\ProductData as DataProductData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ProductData extends UnicodeData implements DataProductData
{
    #[MapInputName('product_items')]
    #[MapName('product_items')]
    #[DataCollectionOf(ProductItemData::class)]
    public ?array $product_items = null;

    public static function before(array &$attributes){
        $attributes['flag'] ??= 'Product';
        $attributes['service'] ??= [
            'name'  => $attributes['name'] ?? 'Unnamed Service',
            'price' => $attributes['price'] ?? 0,
        ];
        $attributes['service']['price'] ??= $attributes['price'] ?? 0;
        $attributes['service']['name'] ??= $attributes['name'] ?? 0;
        parent::before($attributes);
    }
}