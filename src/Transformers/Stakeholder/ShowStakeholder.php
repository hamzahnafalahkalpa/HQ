<?php

namespace Projects\Hq\Transformers\Stakeholder;

use Hanafalah\ModulePeople\Resources\People\ShowPeople;

class ShowStakeholder extends ViewStakeholder
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
      'company' => $this->relationValidation('company',function(){
        return $this->company->toViewApi()->resolve();
      },$this->prop_company)
    ];
    $show = $this->resolveNow(new ShowPeople($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
