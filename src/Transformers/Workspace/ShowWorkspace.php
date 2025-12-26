<?php

namespace Projects\Hq\Transformers\Workspace;

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
    $arr = [
      'product' => $this->relationValidation('product',function(){
        return $this->product->toViewApi()->resolve();
      },$this->prop_product),
      'installed_product_items' => $this->relationValidation('installedProductItems',function(){
        return $this->installedProductItems->transform(function($installedProductItem){
          return $installedProductItem->toViewApi();
        });
      })
    ];
    $show = $this->resolveNow(new WorkspaceShowWorkspace($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
