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
    $arr = [
      'product_code' => $this->product_code
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
