<?php

namespace Projects\Hq\Requests\API\ProductService\License;

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