<?php

namespace Projects\Hq\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Projects\Hq\Contracts\Data\ProductData as DataProductData;

class ProductData extends UnicodeData implements DataProductData
{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'Product';
        parent::before($attributes);
    }
}