<?php

namespace App\Http\Requests;

use App\Libs\Datamap;
use Illuminate\Validation\Rule;

class UpdateUserFormRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::check()) {
            return auth()->user()->can('edit', $this->user);
        }
        return false;
    }

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
                Rule::unique('users')->ignore($this->user->id),
            ],
            'language' => [
                'nullable',
                'in:' . Datamap::getAppLanguages()->pluck('locale')->implode(',')
            ],
            'admin' => [
                'nullable'
            ],
            'password' => [
                'present',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'confirmed',
            ],
            'password_old' => [
                'required',
            ],
            'accesses' => [
                'nullable',
            ]
        ];
    }

    public function withValidator($validator)
    {
        // checks user current password
        // before making changes
        $validator->after(function ($validator) {
            if (!\Hash::check($this->password_old, auth()->user()->password)) {
                $validator->errors()->add('password_old', __('Your current password is incorrect.'));
            }
        });
        return;
    }
}
