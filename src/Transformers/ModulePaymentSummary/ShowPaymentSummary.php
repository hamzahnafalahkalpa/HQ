<?php

namespace Projects\Hq\Transformers\ModulePaymentSummary;

use Hanafalah\ModulePayment\Resources\PaymentSummary\ShowPaymentSummary as PaymentSummaryShowPaymentSummary;

class ShowPaymentSummary extends ViewPaymentSummary
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
    $show = $this->resolveNow(new PaymentSummaryShowPaymentSummary($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
