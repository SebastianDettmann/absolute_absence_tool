<?php

namespace App\Http\Requests;

use App\Libs\Datamap;

class StoreUserFormRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => [
                'required',
                'string'
            ],
            'lastname' => [
                'required',
                'string'
            ],
            'email' => [
                'email',
                'required',
                'unique:users,email',
            ],
            'language' => [
                'nullable',
                'in:' . Datamap::getAppLanguages()->pluck('locale')->implode(','),
            ],
            'admin' => [
                'nullable'
            ],
            'accesses' => [
                'nullable',
            ]
        ];
    }
}
