<?php

namespace Projects\Hq\Resources\Submission;

use Hanafalah\ModuleTransaction\Resources\Submission\ShowSubmission as SubmissionShowSubmission;

class ShowSubmission extends ViewSubmission
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
    $show = $this->resolveNow(new SubmissionShowSubmission($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
