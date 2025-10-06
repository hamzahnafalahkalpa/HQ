<?php

namespace Projects\Hq\Requests\API\Transaction\Submission\Billing\Invoice;

use Projects\Hq\Requests\API\Transaction\Invoice\Environment;

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