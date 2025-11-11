<?php

namespace Projects\Hq\Resources\Workspace;

use Hanafalah\ModuleWorkspace\Resources\Workspace\ViewWorkspace as WorkspaceViewWorkspace;

class ViewWorkspace extends WorkspaceViewWorkspace
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
      'tenant' => $this->relationValidation('tenant',function(){
        return $this->tenant->toViewApi();
      })
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
