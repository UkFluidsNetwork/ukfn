<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Aggregator extends Model
{
    /**
     * Get all aggregators
     * @return objects
     * @author Robert Barczyk <rb783@cam.ac.uk>
     * @static
     * @access public
     */
    public static function getAggregators()
    {
        return DB::table('aggregators')
        ->get();
    } 
}
