<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TalksController extends Controller
{
  public function index()
  {
    return view('talks.index');
  }
}
