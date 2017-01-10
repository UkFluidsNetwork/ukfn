<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TalkUpdateRequest extends Request
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
            "recordinguntil" => "date"
        ];
    }
}