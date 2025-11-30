<?php

namespace Projects\Hq\Resources\Submission;

use Hanafalah\ModuleTransaction\Resources\Submission\ViewSubmission as SubmissionViewSubmission;

class ViewSubmission extends SubmissionViewSubmission
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
      'reference_type' => $this->reference_type,
      'reference_id'   => $this->reference_id,
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
