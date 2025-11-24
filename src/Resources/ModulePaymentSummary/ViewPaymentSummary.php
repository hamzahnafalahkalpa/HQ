<?php

namespace Projects\Hq\Resources\ModulePaymentSummary;

use Hanafalah\ModulePayment\Resources\PaymentSummary\ViewPaymentSummary as PaymentSummaryViewPaymentSummary;

class ViewPaymentSummary extends PaymentSummaryViewPaymentSummary
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
      'xendit' => $this->xendit,
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
