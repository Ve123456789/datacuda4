<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequestPut extends FormRequest
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
            'id' => 'bail|required|integer|exists:plans',
            'storage_quantity' => 'bail|required|integer',
            'storage_unit' => 'bail|required|in:mb,gb,tb',
            'additional' => 'bail|nullable',
            'benifits' => 'bail|required|string|max:2000',
            'commission' => 'bail|required|numeric|min:0|max:100',
            'amount' => 'bail|required|numeric',
            'active' => 'bail|nullable',
            'additional_plan_id' => 'bail|required_if:additional,on|exists:plans'
        ];
    }

    protected function validationData() {
        return array_merge ($this->all(), [
            'id' => $this->route('planId')
        ]);
    }

    public function withValidator($validator) {
        if (!$validator->fails() ) {
            $this->merge([
                'benifits' => array_map ('trim', explode (PHP_EOL, $this->get('benifits'))),
                'additional' => $this->get('additional') === 'on' ? true : false,
                'active' => $this->get('active') === 'on' ? true : false,
            ]);
        }
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages() {
        return [
            'in' => 'The :attribute must have one of the value :values',
            'integer' => 'The :attribute must be a number',
            'numeric' => 'The :attribute must be a number'
        ];
    }
}
