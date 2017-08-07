<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class AcademicDetailsRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return isset(Auth::user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => 'url'
        ];
    }
}

