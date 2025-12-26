<?php

namespace Projects\Hq\Transformers\ModuleBilling;

use Hanafalah\ModulePayment\Resources\Billing\ShowBilling as BillingShowBilling;

class ShowBilling extends ViewBilling
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
    $show = $this->resolveNow(new BillingShowBilling($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
