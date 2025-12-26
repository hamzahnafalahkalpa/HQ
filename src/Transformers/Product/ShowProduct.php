<?php

namespace Projects\Hq\Transformers\Product;

use Hanafalah\LaravelSupport\Resources\Unicode\ShowUnicode as UnicodeShowUnicode;

class ShowProduct extends ViewProduct
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [];
    $show = $this->resolveNow(new UnicodeShowUnicode($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
