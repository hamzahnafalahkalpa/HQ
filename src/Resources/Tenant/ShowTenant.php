<?php

namespace Projects\Hq\Resources\Tenant;

use Hanafalah\MicroTenant\Resources\Tenant\ShowTenant as TenantShowTenant;

class ShowTenant extends ViewTenant
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
    $show = $this->resolveNow(new TenantShowTenant($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
