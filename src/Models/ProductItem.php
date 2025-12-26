<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Projects\Hq\Transformers\ProductItem\{
    ViewProductItem,
    ShowProductItem
};

class ProductItem extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list = ['id', 'name', 'flag', 'product_id', 'master_product_item_id', 'price', 'props'];

    protected $casts = [
        'name' => 'string', 
        'product_id' => 'string',
        'flag' => 'string',
        'master_product_item_id' => 'string'
    ];

    public function getViewResource(){
        return ViewProductItem::class;
    }

    public function getShowResource(){
        return ShowProductItem::class;
    }

    public function product(){return $this->belongsToModel('Product');}
    public function masterProductItem(){return $this->belongsToModel('MasterProductItem');}
}
