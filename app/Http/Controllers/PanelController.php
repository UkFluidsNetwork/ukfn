<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use SEO;

class PanelController extends Controller
{

    /**
     * Render the main panel view
     * 
     * @return \Illuminate\Support\Facades\View
     */
    public function index()
    {
        SEO::setTitle('Panel');
        
        if (!$this->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel','path' => '/panel']
        ];
        $breadCount  = count($bread);

        return view('panel.index', compact('bread', 'breadCount'));
    }

    /**
     * Determine whether the logged in user is part of the administrator's group
     * 
     * @return boolean
     */
    public static function checkIsAdmin()
    {
        if (Auth::user()->group_id != 1) {
            Auth::logout();
            Session::flash('message', 'You must be an administrator to see this page.');
            Session::flash('alert-class', 'alert-danger');
            return false;
        } else {
            return true;
        }
    }
}
