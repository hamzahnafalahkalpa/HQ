<?php

namespace Projects\Hq\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Projects\Hq\Resources\InstalledProductItem\{
    ViewInstalledProductItem,
    ShowInstalledProductItem
};

class InstalledProductItem extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list = [
        'id', 'name', 'reference_type', 'reference_id', 'product_item_id', 'price', 
        'actual_price', 'qty', 'discount', 'total_price', 'props'
    ];

    protected $casts = [
        'name' => 'string', 
        'reference_id' => 'string',
        'reference_type' => 'string',
        'product_item_id' => 'string',
        'price' => 'int'
    ];

    public function getViewResource(){
        return ViewInstalledProductItem::class;
    }

    public function getShowResource(){
        return ShowInstalledProductItem::class;
    }

    public function reference(){return $this->morphTo();}
    public function productItem(){return $this->belongsToModel('ProductItem');}
    public function installedFeature(){return $this->morphOneModel('InstalledFeature','model');}
    public function installedFeatures(){return $this->morphManyModel('InstalledFeature','model');}
}
