<?php

namespace Projects\Hq\Resources\Product;

use Hanafalah\LaravelSupport\Resources\Unicode\ViewUnicode;

class ViewProduct extends ViewUnicode
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $discount = $this->discount ?? 0;
    $price = $this->price ?? 0;
    $arr = [
      "id" => $this->id,
      "name" => $this->name,
      "label" => $this->label,
      'product_code' => $this->product_code,
      'icon' => $this->icon,
      'price' => $this->price,
      'discount' => $this->discount,
      'actual_price' => $price - ($price*$discount),
      'product_items' => $this->relationValidation('productItems',function(){
          return $this->productItems->transform(function($item){
              return $item->toViewApi();
          });
      }),
      'additional_items' => $this->relationValidation('additionalItems',function(){
          return $this->additionalItems->transform(function($item){
              return $item->toViewApi();
          });
      }),
    ];    
    return $arr;
  }
}
