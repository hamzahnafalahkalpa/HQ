<?php

namespace Projects\Hq\Requests\API\ProductService\Submission\Billing;

use Projects\Hq\Requests\API\ProductService\Billing\Environment;

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