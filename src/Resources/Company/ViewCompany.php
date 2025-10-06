<?php

namespace Projects\Hq\Resources\Company;

use Hanafalah\ModulePayer\Resources\Company\ViewCompany as CompanyViewCompany;

class ViewCompany extends CompanyViewCompany
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
      'nib' => $this->nib
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
