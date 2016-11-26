<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Suggestion extends Model
{

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = ['name', 'email', 'institution', 'suggestion', 'leader'];

    public static function getAllSuggestions()
    {
        $suggestions = DB::table('suggestions')->orderBy('suggestion', 'ASC')->get();

        return $suggestions;
    }
}
