<?php

namespace Projects\Hq\Resources\ModuleBilling;

use Hanafalah\ModulePayment\Resources\Billing\ViewBilling as BillingViewBilling;

class ViewBilling extends BillingViewBilling
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
      'invoice'  => $this->relationValidation('invoice', function () {
        return $this->propNil($this->invoice->toShowApi(),'billing');
      }),
      'xendit' => $this->xendit,
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
