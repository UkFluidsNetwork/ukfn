<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Http\Controllers\PanelController;

class EventsFormRequest extends Request
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
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'start' => 'required'
        ];
    }
}
