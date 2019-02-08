<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateReasonFormRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                Rule::unique('reasons')->ignore($this->reason->id)
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'color' => [
                'nullable',
                'string'
            ],
            'hex_color' => [
                'nullable',
                'string'
            ],
            'has_to_confirm' => [
                'nullable'
            ]
        ];
    }
}
