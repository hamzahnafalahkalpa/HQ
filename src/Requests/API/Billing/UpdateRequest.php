<?php

namespace Projects\Hq\Requests\API\Billing;

use Hanafalah\LaravelSupport\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $__entity = 'Billing';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->userAttempt();
        $billing = $this->usingEntity()->findOrFail(request()->id);
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
