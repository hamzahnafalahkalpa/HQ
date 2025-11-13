<?php

namespace Projects\Hq\Resources\Tenant;

use Hanafalah\MicroTenant\Resources\Tenant\ViewTenant as TenantViewTenant;

class ViewTenant extends TenantViewTenant
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
      'product_type' => $this->product_type,
      'is_recurring' => $this->is_recurring,
      'recurring_period' => $this->recurring_period,
      'started_at' => $this->started_at,
      'expired_at' => $this->expired_at
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
