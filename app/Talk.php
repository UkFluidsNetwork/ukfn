<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Talk extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'speaker', 'start', 'end', 'speakerurl', 'venue', 'organiser', 'aggregator_id', 'abstract', 'institution_id', 
        'teradekip', 'streamingurl', 'recordingurl', 'recordinguntil'
    ];


    /**
     * The booting method of the model. It has been overwritten to exclude soft-deleted records from queries
     *
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access protected
     * @static
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('deleted', function (Builder $builder) {
            $builder->where('talks.deleted', '=', '0');
        });
    }

    /**
     * Get current talks only
     * @return array
     * @static
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function getAllCurrentTalks($endFromThisWeek = false)
    {
        if ($endFromThisWeek) {
            $talks = DB::table('talks')
                ->join('aggregators', 'talks.aggregator_id', '=', 'aggregators.id')
                ->where('end', '>', Carbon::now()->startOfWeek())
                ->where('talks.deleted', '=', 0)
                ->select('talks.*', 'aggregators.longname', 'aggregators.name')
                ->orderBy('start', 'ASC')
                ->get();
        } else {
            $talks = DB::table('talks')
                ->join('aggregators', 'talks.aggregator_id', '=', 'aggregators.id')
                ->where('end', '>', Carbon::now())
                ->where('talks.deleted', '=', 0)
                ->select('talks.*', 'aggregators.longname', 'aggregators.name')
                ->orderBy('start', 'ASC')
                ->get();
        }
        
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
            ->join('aggregators', 'talks.aggregator_id', '=', 'aggregators.id')
            ->where('start', '>=', $thisWeekStart->addDays($addDays))
            ->where('start', '<=', $thisWeekEnd->addDays($addDays))
            ->where('talks.deleted', '=', 0)
            ->select('talks.*', 'aggregators.longname', 'aggregators.name')
            ->orderBy('start', 'ASC')
            ->get();
    }

    /**
     * Get this week talks
     * @author Robert Barczyk <robert@barczyk.net>
     * @access public
     * @static
     * @return array
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
     * Get the next n talks
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @static
     * @param int $limit
     * @return array
     */
    public static function getUpcomingTalks($limit = 20)
    {
        return DB::table('talks')
            ->where('start', '>=', Carbon::now())
            ->where('talks.deleted', '=', 0)
            ->orderBy('start', 'ASC')
            ->limit($limit)->get();
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
            ->where('talks.deleted', '=', 0)
            ->orderBy('start', 'ASC')
            ->get();
    }

    /**
     * Find a talk given its talk id
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @static
     * @param string $talkid
     * @return array
     */
    public static function findByTalkid($talkid)
    {
        return DB::table('talks')
            ->where('talkid', '=', $talkid)
            ->where('talks.deleted', '=', 0)
            ->get();
    }

    /**
     * Get current talks only
     * 
     * @return array
     */
    public static function getCurrentTalks()
    {
        return DB::table('talks')->where('end', '>', Carbon::now())->orderBy('start', 'ASC')->get();
    }

    /**
     * Get current talks only
     * 
     * @return array
     */
    public static function getPastTalks()
    {
        return DB::table('talks')->where('end', '<', Carbon::now())->orderBy('start', 'ASC')->get();
    }

    /**
     * Get current talks only
     * 
     * @return array
     */
    public static function getRecordedTalks()
    {
        return DB::table('talks')
            ->whereNotNull('recordingurl')
            ->where('recordingurl', '<>', '')
            ->orderBy('start', 'ASC')
            ->get();
    }
    
    /**
     * Determine whether this talk is to be streamed
     * 
     * @return boolean
     */
    public function isStreamed()
    {
        return $this->streamingurl !== null && $this->streamingurl !== "";
    }
    
    /**
     * Determine whether this talk has been recorded and we are allowed to display the recording
     * 
     * @return boolean
     */
    public function isRecorded()
    {
        return $this->recordingurl !== null && $this->recordingurl !== "" && ($this->recordinguntil === null || Carbon::parse($this->recordinguntil) > Carbon::now());
    }
    
    /**
     * Determine whether the stream for this talk can be displayed. It defaults to the duration of the talk plus 15 minutes before and after.
     * 
     * @return boolean
     */
    public function displayStream()
    {
        return $this->recordingurl !== null && $this->recordingurl !== "" && (Carbon::now() >= Carbon::parse($this->start)->addMinutes(-15) && Carbon::now() <= Carbon::parse($this->end)->addMinutes(15));
    }
}
