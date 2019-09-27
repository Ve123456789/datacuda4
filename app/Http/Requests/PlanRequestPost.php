<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequestPost extends FormRequest
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
            'name' => 'bail|required|string|max:191|unique:plans',
            'storage_quantity' => 'bail|required|integer',
            'storage_unit' => 'bail|required|in:mb,gb,tb',
            'additional' => 'bail|nullable',
            'benifits' => 'bail|required|string|max:2000',
            'commission' => 'bail|required|numeric|min:0|max:100',
            'amount' => 'bail|required|numeric',
            'additional_plan_id' => 'bail|nullable|required_if:additional,on|exists:plans,id',
            'vailidity_quantity' => 'bail|required|integer',
            'validity_unit' => 'bail|required|in:days,months,years',
        ];
    }

    public function withValidator($validator) {
        if (!$validator->fails() ) {
            $this->merge([
                'benifits' => array_map ('trim', explode (PHP_EOL, $this->get('benifits'))),
                'additional' => $this->get('additional') === 'on' ? true : false
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
