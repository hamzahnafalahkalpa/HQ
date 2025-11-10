<?php

namespace Projects\Hq\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Projects\Hq\Contracts\Data\MasterProductItemData as DataMasterProductItemData;

class MasterProductItemData extends UnicodeData implements DataMasterProductItemData
{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'MasterProductItem';
        parent::before($attributes);
    }
}