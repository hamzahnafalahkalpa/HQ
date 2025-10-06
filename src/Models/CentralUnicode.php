<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelSupport\Models\Unicode\Unicode;

class CentralUnicode extends Unicode
{
    protected $table = 'unicodes';

    public function getForeignKey(){
        return 'unicode_id';
    }
}
