<?php

namespace Projects\HQ\Requests\API\User;

use Projects\WellmedLite\Requests\API\Transaction\Deposit\Environment;

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
