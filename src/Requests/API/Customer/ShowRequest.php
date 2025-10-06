<?php

namespace Projects\Hq\Requests\API\Customer;

class ShowRequest extends Environment
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
