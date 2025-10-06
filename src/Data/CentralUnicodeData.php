<?php

namespace Projects\Hq\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Projects\Hq\Contracts\Data\CentralUnicodeData as DataCentralUnicodeData;

class CentralUnicodeData extends UnicodeData implements DataCentralUnicodeData
{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'CentralUnicode';
        parent::before($attributes);
    }
}