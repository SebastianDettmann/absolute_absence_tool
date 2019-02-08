<?php

namespace App\Http\Requests;

use Carbon\Carbon;

class StorePeriodFormRequest extends AbstractFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start' => [
                'required',
                'after:' . Carbon::yesterday()->format('d.m.Y'),
                'date_format:d.m.Y',
            ],
            'end' => [
                'required',
                'after:start_at -1',
                'date_format:d.m.Y',

            ],
            'comment' => [
                'nullable',
                'string'
            ],
            'reason_id' => [
                'required',
                'integer',
                'exists:reasons,id'
            ],
        ];
    }
}
