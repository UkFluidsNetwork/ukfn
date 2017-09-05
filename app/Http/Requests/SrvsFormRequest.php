<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SrvsFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
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
            'name' => 'required',
            'description' => 'required',
            'visitor' => 'required',
            'visiting' => 'required'
        ];
    }
}

