<?php

namespace Projects\Hq\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Projects\Hq\Contracts\Data\ProductItemData as DataProductItemData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ProductItemData extends Data implements DataProductItemData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public ?string $name = null;

    #[MapInputName('flag')]
    #[MapName('flag')]
    public ?string $flag = null;

    #[MapInputName('product_id')]
    #[MapName('product_id')]
    public mixed $product_id = null;

    #[MapInputName('master_product_item_id')]
    #[MapName('master_product_item_id')]
    public mixed $master_product_item_id = null;

    #[MapInputName('price')]
    #[MapName('price')]
    public ?int $price = null;

    #[MapInputName('master_product_item')]
    #[MapName('master_product_item')]
    public ?MasterProductItemData $master_product_item = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        $attributes['flag'] ??= 'Main';
    }
}