<?php

namespace Projects\Hq\Resources\Company;

use Hanafalah\ModulePayer\Resources\Company\ShowCompany as CompanyShowCompany;

class ShowCompany extends ViewCompany
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
      'business_description' => $this->business_description,
      'stakeholder' => $this->relationValidation('stakeholder',function(){
        return $this->stakeholder->toShowApi()->resolve();
      })
    ];
    $show = $this->resolveNow(new CompanyShowCompany($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
