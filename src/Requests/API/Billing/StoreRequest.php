<?php

namespace Projects\Hq\Requests\API\Billing;

use Hanafalah\LaravelSupport\Requests\FormRequest;

class StoreRequest extends FormRequest
{
    protected $__entity = 'Billing';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->userAttempt();
        if (isset(request()->id)){
            $billing = $this->usingEntity()->findOrFail(request()->id);
            if (isset($billing->reported_at)){
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        ];
    }
}
