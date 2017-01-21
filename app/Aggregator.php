<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Aggregator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'longname'
    ];

    /**
     * Get all aggregators
     * @return objects
     * @author Robert Barczyk <robert@barczyk.net>
     * @static
     * @access public
     */
    public static function getAggregators()
    {
        return DB::table('aggregators')
        ->where('deleted', '=', 0)
        ->get();
    } 
}
