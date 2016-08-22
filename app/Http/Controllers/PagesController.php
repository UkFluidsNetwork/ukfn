<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ContactUsRequest;

class PagesController extends Controller
{
  public function contact()
  {
    return view('pages.contact');
  }
    
  public function sendMessage(ContactUsRequest $request) 
  {
    $res = var_dump($_POST);
    // do some magic and return redirect('articles');
    //Article::create($request->all());
    return view('pages.contact', compact('res'));
  }
}
