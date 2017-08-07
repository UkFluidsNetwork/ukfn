<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AggregatorsFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'name' => 'required|max:255',
            'longname' => 'required|max:255'
        ];
    }
}
