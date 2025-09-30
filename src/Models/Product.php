<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Projects\Hq\Resources\Product\{
    ViewProduct,
    ShowProduct
};

class Product extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'product_code', 'flag', 'name', 'props'
    ];
    public $show = [];

    protected $casts = [
        'name' => 'string', 
        'flag' => 'string',
        'product_code' => 'string'
    ];

    public function getPropsQuery(): array{
        return [
        ];
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function($query){
            if (!isset($query->product_code)){
                $query->product_code = static::hasEncoding('PRODUCT_CODE'); 
            }
        });
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewProduct::class;
    }

    public function getShowResource(){
        return ShowProduct::class;
    }
}
