<?php

namespace Projects\Hq\Transformers\Stakeholder;

use Hanafalah\ModulePeople\Resources\People\ViewPeople;

class ViewStakeholder extends ViewPeople
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
      'company_id' => $this->company_id,
      'company'    => $this->prop_company
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
