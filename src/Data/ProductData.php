<?php

namespace Projects\Hq\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Projects\Hq\Contracts\Data\ProductData as DataProductData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ProductData extends Data implements DataProductData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('flag')]
    #[MapName('flag')]
    public string $flag;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}