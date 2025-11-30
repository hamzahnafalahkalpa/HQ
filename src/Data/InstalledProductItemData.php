<?php

namespace Projects\Hq\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Projects\Hq\Contracts\Data\InstalledProductItemData as DataInstalledProductItemData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class InstalledProductItemData extends Data implements DataInstalledProductItemData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public ?string $name = null;

    #[MapInputName('submission_id')]
    #[MapName('submission_id')]
    public mixed $submission_id = null;

    #[MapInputName('reference_type')]
    #[MapName('reference_type')]
    public ?string $reference_type = null;

    #[MapInputName('reference_id')]
    #[MapName('reference_id')]
    public mixed $reference_id = null;

    #[MapInputName('product_item_id')]
    #[MapName('product_item_id')]
    public mixed $product_item_id = null;

    #[MapInputName('price')]
    #[MapName('price')]
    public ?int $price = null;

    #[MapInputName('actual_price')]
    #[MapName('actual_price')]
    public ?int $actual_price = null;

    #[MapInputName('qty')]
    #[MapName('qty')]
    public ?int $qty = null;

    #[MapInputName('discount')]
    #[MapName('discount')]
    public ?float $discount = null;

    #[MapInputName('total_price')]
    #[MapName('total_price')]
    public ?int $total_price = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        $new = self::new();
        $product_item = $new->ProductItemModel()->findOrFail($attributes['product_item_id']);
        $attributes['name'] ??= $product_item->name;
        $attributes['price'] ??= $product_item->price;
        $attributes['qty'] ??= 1;
        $attributes['discount'] ??= 0;
        $attributes['actual_price'] ??= ($attributes['price']*$attributes['qty']) - $attributes['discount'];
        $attributes['total_price'] ??= $attributes['qty'] * $attributes['actual_price'];
        $attributes['prop_product_item'] = $product_item->toViewApi()->resolve();
    }
}