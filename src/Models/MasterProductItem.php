<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Projects\Hq\Resources\Product\{
    ViewMasterProductItem,
    ShowMasterProductItem
};

class MasterProductItem extends CentralUnicode
{
    use HasUlids, HasProps, SoftDeletes;

    protected $table = 'unicodes';

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewMasterProductItem::class;
    }

    public function getShowResource(){
        return ShowMasterProductItem::class;
    }

    public function productItems(){return $this->hasManyModel('ProductItem');}
}
