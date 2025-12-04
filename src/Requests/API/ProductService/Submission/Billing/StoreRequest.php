<?php

namespace Projects\Hq\Requests\API\ProductService\Submission\Billing;

use Projects\Hq\Requests\API\ProductService\Billing\Environment;

class StoreRequest extends Environment
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
