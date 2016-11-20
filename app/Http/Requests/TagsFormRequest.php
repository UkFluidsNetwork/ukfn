<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Http\Controllers\PanelController;

class TagsFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     * @author Javier Arias <ja573@cam.ac.uk>
     */
    public function authorize()
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return false;
        } else {
            return true;
        }
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
            'name' => 'required',
            'tagtype_id' => 'required',
            'category' => 'required'
        ];
    }
}
