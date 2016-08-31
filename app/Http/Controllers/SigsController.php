<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sig;
use App\Suggestion;
use App\Http\Requests;
use DateTime;

class SigsController extends Controller
{
  public function index()
  {
    $allSuggestions = Suggestion::getAllSuggestions();
    $newCount = 0;
   
    foreach($allSuggestions as $suggestion) {
      // create datetime objects for created_at and today
      $created_at = new DateTime($suggestion->created_at);
      $today = new DateTime();
      // suggestions older than 7 days will be marked as new.
      $difference = (int)$today->diff($created_at)->format('%R%a');
      if($difference >= -7 && $difference <= 0) {
        $suggestion->new = "<span class='badge badge-success'>new</span>";
        $newCount++;
      } else {
        $suggestion->new = "";
      }
    }
     
    return view('sig.index', compact('allSuggestions', 'newCount'));
  }
}
