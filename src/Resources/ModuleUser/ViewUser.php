<?php

namespace Projects\Hq\Resources\ModuleUser;

use Hanafalah\ModuleUser\Resources\ViewUser as ResourcesViewUser;

class ViewUser extends ResourcesViewUser
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
      'name' => $this->name,
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
