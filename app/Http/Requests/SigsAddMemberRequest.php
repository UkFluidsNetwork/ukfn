<?php

namespace App\Http\Requests;
use Auth;
use App\Http\Requests\Request;
use App\Http\Controllers\PanelController;

class SigsAddMemberRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @author Javier Arias <robert@abrczyk.net>
     */
    public function authorize()
    {
        $admin = new PanelController();
        $sigLeader = Auth::user()->sigLeader();
        
        // if not leader of this sig
        if (empty($sigLeader)) {
            // if not admin
            if (!$admin->checkIsAdmin()) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Javier Arias <robert@abrczyk.net>
     */
    public function rules()
    {
        return [
            
//////////////// pu val for int??
            
            'main' => 'required',
            'user_id' => 'required',
            'sig_id' => 'required'
        ];
    }
}
