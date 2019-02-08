<?php

namespace App\Http\Requests;


class StoreReasonFormRequest extends AbstractFormRequest
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
                'unique:reasons,title'
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
