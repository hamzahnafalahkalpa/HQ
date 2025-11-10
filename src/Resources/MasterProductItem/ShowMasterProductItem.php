<?php

namespace Projects\Hq\Resources\MasterProductItem;

use Hanafalah\LaravelSupport\Resources\Unicode\ShowUnicode as UnicodeShowUnicode;

class ShowMasterProductItem extends ViewMasterProductItem
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
