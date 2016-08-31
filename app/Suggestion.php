<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
  public static function addSuggestion($name, $email, $institution, $suggestions)
  {
    $sug               = new Suggestion();
    $sug->name         = $name;
    $sug->email        = $email;
    $sug->institution  = $institution;
    $sug->suggestion   = $suggestions;
    $sug->save();
  }
  
  public static function getAllSuggestions()
  {
    $suggestion = \DB::table('suggestions')->orderBy('created_at', 'ASC')->get();

    return $suggestion;
  }
}
