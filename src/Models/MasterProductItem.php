<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Projects\Hq\Resources\Product\{
    ViewMasterProductItem,
    ShowMasterProductItem
};

class MasterProductItem extends Unicode
{
    use HasUlids, HasProps, SoftDeletes;

    protected $table = 'unicodes';

    // protected static function booted(): void{
    //     parent::booted();
    //     static::creating(function($query){
    //         if (!isset($query->product_code)){
    //             $query->product_code = static::hasEncoding('PRODUCT_CODE'); 
    //         }
    //     });
    // }

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
