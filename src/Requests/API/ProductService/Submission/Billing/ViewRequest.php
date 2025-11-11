<?php

namespace Projects\Hq\Requests\API\ProductService\Submission\Billing;

use Projects\Hq\Requests\API\Transaction\Billing\Environment;

class ViewRequest extends Environment
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
    ];
  }
}