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
}
