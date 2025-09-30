<?php

namespace Projects\Hq\Requests\API\User;

use Projects\WellmedLite\Requests\API\Transaction\Deposit\Environment;

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
