<?php

namespace Projects\Hq\Requests\API\ProductService\License;

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
