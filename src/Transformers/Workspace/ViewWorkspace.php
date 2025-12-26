<?php

namespace Projects\Hq\Transformers\Workspace;

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
      'product_id' => $this->product_id,
      'product' => $this->relationValidation('product',function(){
        return $this->product->toViewApi()->resolve();
      },$this->prop_product),
      'submission_id' => $this->submission_id,
      'submission' => $this->relationValidation('submission',function(){
        return $this->submission->toViewApi()->resolve();
      },$this->prop_submission),
      'tenant' => $this->relationValidation('tenant',function(){
        return $this->tenant->toViewApi();
      })
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
