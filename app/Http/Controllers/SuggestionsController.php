<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SigSuggestionFormRequest;
use App\Http\Requests;
use App\Suggestion;

class SuggestionsController extends Controller
{
  public function postSuggestion(SigSuggestionFormRequest $request)
  {
    // validate input data from form
    $name    = $request->input('name');
    $email    = $request->input('email');
    $suggestion = $request->input('suggestion');
    $institution = $request->input('institution');
    
    // Add suggestion to the databse
   
    Suggestion::addSuggestion($name, $email, $institution, $suggestion);
        
    // set success message
    \Session::flash('success_message', 'Thank you, your suggestion has been posted. ');
    return redirect('/sig');
  }
}
