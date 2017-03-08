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
     * Find a talk given its talk id
     *
     * @param string $talkid
     * @return array
     */
    public static function findByTalkid($talkid)
    {
        return DB::table('talks')->where('talkid', '=', $talkid)->get();
    }

    /**
     * Get current talks only
     * 
     * @return array
     */
    public static function getFutureTalks($aggregators = [])
    {
        return DB::table('talks')
            ->leftJoin('aggregators', 'talks.aggregator_id', '=', 'aggregators.id')
            ->select('talks.*')
            ->where('talks.end', '>', Carbon::now())
            ->where(function($query) use ($aggregators) {
                if (!empty($aggregators)) {
                    foreach ($aggregators as $aggregator) {
                        $query->orWhere('aggregators.id', $aggregator);
                    }
                }
            })
            ->orderBy('talks.start', 'ASC')
            ->get();
    }

    /**
     * Get current talks only
     * 
     * @return array
     */
    public static function getPastTalks($aggregators = [])
    {
        return DB::table('talks')
            ->leftJoin('aggregators', 'talks.aggregator_id', '=', 'aggregators.id')
            ->select('talks.*')
            ->where('talks.end', '<', Carbon::now())
            ->where(function($query) use ($aggregators) {
                if (!empty($aggregators)) {
                    foreach ($aggregators as $aggregator) {
                        $query->orWhere('aggregators.id', $aggregator);
                    }
                }
            })
            ->orderBy('talks.start', 'DESC')
            ->get();
    }

    /**
     * Get current talks only
     * 
     * @return array
     */
    public static function getRecordedTalks($searchTerms = [])
    {
        return DB::table('talks')
            ->whereNotNull('recordingurl')
            ->where('recordingurl', '<>', "")
            ->where(function($query) use ($searchTerms) {
                if (!empty($searchTerms)) {
                    foreach ($searchTerms as $term) {
                        $query->orWhere('title', 'like', "%${term}%");
                        $query->orWhere('speaker', 'like', "%${term}%");
                        $query->orWhere('abstract', 'like', "%${term}%");
                    }
                }
            })
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
     * Determine whether the stream for this talk can be displayed. It defaults to the duration of the talk plus 15m before and 1h after.
     * 
     * @return boolean
     */
    public function displayStream()
    {
        return $this->recordingurl !== null && $this->recordingurl !== "" && (Carbon::now() >= Carbon::parse($this->start)->addMinutes(-15) && Carbon::now() <= Carbon::parse($this->end)->addMinutes(60));
    }
}
