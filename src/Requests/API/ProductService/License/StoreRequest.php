<?php

namespace Projects\Hq\Requests\API\ProductService\License;

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
