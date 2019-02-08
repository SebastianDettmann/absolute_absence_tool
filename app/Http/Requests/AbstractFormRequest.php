<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class AbstractFormRequest extends FormRequest
{
    protected $failedMessage = 'save_failed';

    public function authorize()
    {
        if (\Auth::check()) {
            return true;
        }
        return false;
    }


    #TODO delete this function?
    protected function formatErrors(Validator $validator)
    {

        \Alert::error(trans('alerts.' . $this->failedMessage))->flash();
        return $validator->getMessageBag()->toArray();
    }

    /**
     * Handle a failed validation attempt.
     * overrides Illuminate\Foundation\Http\FormRequest
     * add Alert::error('errortext')->flash()
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        \Alert::error(trans('alerts.' . $this->failedMessage))->flash();

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
