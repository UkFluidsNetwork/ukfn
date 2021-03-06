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
        'title', 'speaker', 'start', 'end', 'speakerurl', 'venue',
        'organiser', 'aggregator_id', 'abstract', 'institution_id',
        'teradekip', 'streamingurl', 'recordingurl', 'recordinguntil'
    ];

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
            ->leftJoin('aggregators',
                       'talks.aggregator_id', '=', 'aggregators.id')
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
            ->leftJoin('aggregators',
                       'talks.aggregator_id', '=', 'aggregators.id')
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
            ->orderBy('start', 'DESC')
            ->get();
    }

    /**
     * Determine whether this talk is to be streamed
     *
     * @return boolean
     */
    public function isStreamed()
    {
        return ($this->streamingurl !== null && $this->streamingurl !== "")
            ||($this->teradekip !== null && $this->teradekip !== "");
    }

    /**
     * Determine whether this talk has been recorded
     * and we are allowed to display the recording
     *
     * @return boolean
     */
    public function isRecorded()
    {
        return $this->recordingurl !== null && $this->recordingurl !== "";
    }

    /**
     * Determine whether the stream for this talk can be displayed.
     * It defaults to the duration of the talk plus 15m before and 1h after.
     *
     * @return boolean
     */
    public function displayStream()
    {
        return $this->isStreamed() && !$this->isFuture() && !$this->isPast();
    }

    /**
     * Determine whether the recording for this talk can be displayed.
     *
     * @return boolean
     */
    public function displayRecording()
    {
        return $this->isRecorded() && ($this->recordinguntil === null
            || $this->recordinguntil === "0000-00-00"
            || Carbon::parse($this->recordinguntil) > Carbon::now());
    }

    /**
     * Determine whether a talk is in the future
     *
     * @return boolean
     */
    public function isFuture()
    {
        return Carbon::now() < Carbon::parse($this->start)->addMinutes(-15);
    }

    /**
     * Determine whether a talk is in the past
     *
     * @return boolean
     */
    public function isPast()
    {
        return Carbon::now() > Carbon::parse($this->end)->addMinutes(60);
    }
}
