<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Talk;
use App\Http\Requests;

class TalksController extends Controller
{
  public function index()
  {
    $exceptions = ["TBC", "tbc", "To be confirmed", "Title to be confirmed", "TBD"];
    
    $talks = [];
    $index = 0;
    Talk::updateTalks();
    $allTalks = Talk::getAllTalks();
    
    foreach($allTalks as $talk) {
      if(in_array($talk->title, $exceptions)) {
        continue;
      }
      $talks[$index]['title'] = $talk->title;
      $talks[$index]['when'] = date("l jS F", strtotime($talk->start)) . " at " . date("H:i", strtotime($talk->start));
      $talks[$index]['speaker'] = $talk->speaker;
      $talks[$index]['abstract'] = $talk->abstract;
      if(!strpos(strtolower($talk->venue), "university of cambridge")) {
        $talks[$index]['venue'] = $talk->venue .", University of Cambridge";
      } else {
        $talks[$index]['venue'] = $talk->venue;        
      }
      $index++;
    }

    return view('talks.index', compact('talks'));
  }
}
