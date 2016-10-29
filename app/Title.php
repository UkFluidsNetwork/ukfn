<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{

    /**
     * Get all titles
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return array
     */
    public static function getAll()
    {
        return DB::table('titles')->get();
    }

    /**
     * Get the users associated with the given title
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
