<?php

namespace Projects\Hq\Resources\ProductItem;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewProductItem extends ApiResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [
      'id' => $this->id,
      'name' => $this->name,
      'flag' => $this->flag,
      'label' => $this->label,
      'product_id' => $this->product_id,
      'master_product_item_id' => $this->master_product_item_id,
      'price' => $this->price,
      'discount' => $this->discount,
      'actual_price' => $this->price - ($this->price * ($this->discount / 100)),
      'dynamic_forms' => $this->dynamic_forms,
    ];
    return $arr;
  }
}
