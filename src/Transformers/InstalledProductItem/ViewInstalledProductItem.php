<?php

namespace Projects\Hq\Transformers\InstalledProductItem;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewInstalledProductItem extends ApiResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $qty = $this->qty ?? 1;
    $arr = [
      'id' => $this->id,
      'name' => $this->name,
      'reference_type' => $this->reference_type,
      'reference_id' => $this->reference_id,
      'product_item_id' => $this->product_item_id,
      'price'        => $this->price,
      'actual_price' => $this->qty,
      'discount' => $this->qty,
      'total_price' => $qty * $this->actual_price,
      'qty' => $qty,
    ];
    return $arr;
  }
}
