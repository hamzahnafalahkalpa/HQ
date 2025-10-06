<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Projects\Hq\Resources\Product\{
    ViewProduct,
    ShowProduct
};

class Product extends Unicode
{
    use HasUlids, HasProps, SoftDeletes;

    protected $table = 'unicodes';

    protected $casts = [
        'name' => 'string', 
        'flag' => 'string',
        'product_code' => 'string',
        'label'  => 'string'
    ];

    public function getPropsQuery(): array{
        return [
            'product_code' => 'props->product_code'
        ];
    }

    protected function isUsingService(): bool{
        return true;
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function($query){
            if (!isset($query->product_code)){
                $query->product_code = static::hasEncoding('PRODUCT_CODE'); 
            }
        });
    }

    // public function viewUsingRelation(): array{
    //     return [];
    // }

    // public function showUsingRelation(): array{
    //     return [];
    // }

    public function getViewResource(){
        return ViewProduct::class;
    }

    public function getShowResource(){
        return ShowProduct::class;
    }
}
