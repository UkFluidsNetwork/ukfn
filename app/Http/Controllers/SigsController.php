<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sig;
use App\Suggestion;
use App\Http\Requests;

class SigsController extends Controller
{
  public function index()
  {
    $allSuggestions = Suggestion::getAllSuggestions();
   
     
    return view('sig.index', compact('allSuggestions'));
  }
}
