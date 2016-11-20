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
     * @author Javier Arias <ja573@cam.ac.uk>
     */
    public function authorize()
    {
        return isset(Auth::user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Javier Arias <ja573@cam.ac.uk>
     */
    public function rules()
    {
        return [
            'url' => 'url'
        ];
    }
}
