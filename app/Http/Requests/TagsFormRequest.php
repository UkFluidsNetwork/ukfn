<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TagsFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
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
            'tagtype_id' => 'required',
            'category' => 'required'
        ];
    }
}

