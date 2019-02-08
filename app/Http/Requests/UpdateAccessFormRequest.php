<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateAccessFormRequest extends AbstractFormRequest
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
                Rule::unique('accesses')->ignore($this->access->id),
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
