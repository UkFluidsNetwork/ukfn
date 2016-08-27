<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Session;

class AdminController extends Controller
{
  public function index()
  {
    if(!$this->checkIsAdmin()) {
      return redirect('/');
    }

    return view('admin.index');
  }
  
  public function checkIsAdmin()
  {
    if(Auth::user()->group_id != 1) {
      Auth::logout();
      Session::flash('message', 'You must be an administrator to see this page.'); 
      Session::flash('alert-class', 'alert-danger');
      return false;
    } else {
      return true;
    }
  }
  
}
