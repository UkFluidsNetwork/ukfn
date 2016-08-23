<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Talk;
use App\Http\Requests;

class TalksController extends Controller
{
  public function index()
  {
    Talk::updateTalks();
    $allTalks = Talk::getAllTalks();
    
    return view('talks.index', compact('allTalks'));
  }
}
