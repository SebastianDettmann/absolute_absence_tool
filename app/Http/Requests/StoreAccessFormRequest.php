<?php

namespace App\Http\Requests;


class StoreAccessFormRequest extends AbstractFormRequest
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
                'unique:accesses,title',
            ],
            'url' => [
                'nullable',
                'string',
            ],
            'image' => [
                'nullable',
                'string',
            ],
        ];
    }
}
