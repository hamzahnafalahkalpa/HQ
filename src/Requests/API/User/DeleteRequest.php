<?php

namespace Projects\HQ\Requests\API\User;

class DeleteRequest extends Environment
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [];
  }
}