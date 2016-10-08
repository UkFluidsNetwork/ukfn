<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Talk extends Model 
{
    /**
     * Get current talks only
     * @return array
     * @static
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function getAllCurrentTalks()
    {
        $talks = DB::table('talks')->where('end', '>', Carbon::now())->orderBy('start', 'ASC')->get();

        return $talks;
    }

    /**
     * Get talks for given week
     * @param int $addDays add 7 to get next week
     * @return array
     * @access private
     * @static
     * @author Robert Barczyk <robert@barczyk.net>
     */
    private static function getWeeklyTalks($addDays = 0)
    {
        $thisWeekStart = Carbon::now()->startOfWeek();
        $thisWeekEnd = Carbon::now()->endOfWeek();
        
        return $talks = DB::table('talks')
            ->where('start', '>=', $thisWeekStart->addDays($addDays))
            ->where('start', '<=', $thisWeekEnd->addDays($addDays))
            ->orderBy('start', 'ASC')
            ->get();
    }
    
    /**
     * Get this week talks
     * @author Robert Barczyk <robert@barczyk.net>
     * @access public
     * @static
     * @return array
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function getTalksThisWeek()
    {
        return self::getWeeklyTalks(0);
    }
    
    /**
     * Get next week talks
     * @access public
     * @static
     * @return array
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function getTalksNextWeek()
    {
        return self::getWeeklyTalks(7);
    }
    
    /**
     * @todo TO MAKE IT MORE GENERIC ADD YEAR ETC
     * Get all talks per month
     * @param type $addMonth
     * @return type
     * @access public
     * @static
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function getMonthlyTalks($addMonth = 0)
    {
        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisMonthEnd = Carbon::now()->endOfMonth();
                
        return $talks = DB::table('talks')
            ->where('start', '>=', $thisMonthStart->addMonth($addMonth))
            ->where('start', '<=', $thisMonthEnd->addDays($addMonth))
            ->orderBy('start', 'ASC')
            ->get(); 
    }    
}
