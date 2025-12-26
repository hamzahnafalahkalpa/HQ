<?php

namespace Projects\Hq\Transformers\InstalledProductItem;

class ShowInstalledProductItem extends ViewInstalledProductItem
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
      'product_item' => $this->prop_product_item
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
