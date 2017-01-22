<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TalksFormRequest extends Request
{
    /**
     * Determine if the user is authorised to make this request.
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
            "recordinguntil" => "date",
            "title" => "required",
            "speaker" => "required",
            'speakerurl' => 'url',
            "start" => "required | date",
            'end' => "required | date",
            'venue' => 'required | string',
            'organiser' => 'string',
            'aggregator_id' => 'required | integer',
            'institution_id' => 'integer',
            'abstract'=> 'required | string'
        ];
    }
}