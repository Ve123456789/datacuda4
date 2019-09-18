<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaySubscriptionPlanPost extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'bail|required',
            'subscriptionPlanId' => 'bail|required|exists:plans,id,deleted_at,NULL,active,1'
        ];
    }
}
