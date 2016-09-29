<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Talk extends Model {
    /**
     * Gett all talks except old ones
     * @return array
     * @static
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function getAllTalks() {
        $talks = DB::table('talks')->where('end', '>', Carbon::now())->orderBy('start', 'ASC')->get();

        return $talks;
    }

}
