<?php

namespace Projects\Hq\Requests\API\Transaction\Submission\Billing;

use Projects\Hq\Requests\API\Transaction\Billing\Environment;

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