<?php

namespace Projects\Hq\Transformers\ModuleUser;

use Hanafalah\LaravelSupport\Resources\Unicode\ShowUnicode;
use Hanafalah\ModuleUser\Resources\ShowUser as ResourcesShowUser;

class ShowUser extends ViewUser
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
    $show = $this->resolveNow(new ResourcesShowUser($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
