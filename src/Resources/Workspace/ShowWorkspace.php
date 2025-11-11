<?php

namespace Projects\Hq\Resources\Workspace;

use Hanafalah\ModuleWorkspace\Resources\Workspace\ShowWorkspace as WorkspaceShowWorkspace;

class ShowWorkspace extends ViewWorkspace
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
    $show = $this->resolveNow(new WorkspaceShowWorkspace($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
