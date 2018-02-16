<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TutorialFileFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     * We allow all requests as middleware is taking care of it.
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
            'file_id' => 'required|integer',
            'filetype_id' => 'required|integer',
        ];
    }
}

