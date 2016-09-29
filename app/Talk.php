<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Talk extends Model {

    /**
     * Function fetch talks from talks.cam and store them in local DB
     * @static
     * @access public
     * @todo TRY CATCH needs to be added for sql and XML
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function updateTalks() {
        $xmlLink = "http://talks.cam.ac.uk/show/xml/54169";

        $talkAggregator = simplexml_load_file($xmlLink);

        foreach ($talkAggregator->talk as $value) {
            $existingTalk = DB::table('talks')->where('talkid', '=', $value->id)->get();

            // Insert new record if fetched talk doesn't exist in our DB 
            if (empty($existingTalk)) {
                // create talk object and assign attributes
                $talk = new Talk();
                $talk->talkid = $value->id;
                $talk->title = $value->title;
                $talk->speaker = $value->speaker;
                $talk->start = Carbon::createFromFormat('D, d M Y H:i:s e', $value->start_time)->format('Y-m-d H:i:s');
                $talk->end = Carbon::createFromFormat('D, d M Y H:i:s e', $value->end_time)->format('Y-m-d H:i:s');
                $talk->url = $value->url;
                $talk->speakerurl = $value->speaker_url;
                $talk->venue = $value->venue;
                $talk->organiser = $value->organiser;
                $talk->series = $value->series;
                $talk->aggregator = $talkAggregator->id;
                $talk->abstract = $value->abstract;
                $talk->message = $value->special_message;
                $talk->created_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->created_at)->format('Y-m-d H:i:s');
                $talk->updated_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->updated_at)->format('Y-m-d H:i:s');
                $talk->deleted = 0;
                $talk->save();
            }
            // Otherwise update existing one
            else {
                $talk = new Talk();
                $talk->talkid = $value->id;
                $talk->title = $value->title;
                $talk->speaker = $value->speaker;
                $talk->start = Carbon::createFromFormat('D, d M Y H:i:s e', $value->start_time)->format('Y-m-d H:i:s');
                $talk->end = Carbon::createFromFormat('D, d M Y H:i:s e', $value->end_time)->format('Y-m-d H:i:s');
                $talk->url = $value->url;
                $talk->speakerurl = $value->speaker_url;
                $talk->venue = $value->venue;
                $talk->organiser = $value->organiser;
                $talk->series = $value->series;
                $talk->aggregator = $talkAggregator->id;
                $talk->abstract = $value->abstract;
                $talk->message = $value->special_message;
                $talk->created_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->created_at)->format('Y-m-d H:i:s');
                $talk->updated_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->updated_at)->format('Y-m-d H:i:s');
                $talk->deleted = 0;
                $talk->update();
            }
        }
    }

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
