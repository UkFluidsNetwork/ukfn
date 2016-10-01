<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Talk;
use DB;
use Carbon\Carbon;
use App\Http\Requests;
use SEO;

class TalksController extends Controller {

    public function index() {
        SEO::setTitle('Talks');
        SEO::setDescription('Feed of fluids-related seminars in the UK.'
                . ' Currently all talks are imported from the  Cambridge Fluids Network - fluids-related seminars RSS feed. '
                . 'To link another RSS feed to this page, please contact us.');

        $exceptions = ["TBC", "tbc", "To be confirmed", "Title to be confirmed", "TBD"];

        
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
                $talk = Talk::find($existingTalk[0]->id);
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
        }
        
        $talks = [];
        $index = 0;
        $allTalks = Talk::getAllTalks();

        foreach ($allTalks as $talk) {
            if (in_array($talk->title, $exceptions)) {
                continue;
            }
            $talks[$index]['title'] = $talk->title;
            $talks[$index]['when'] = date("l jS F", strtotime($talk->start)) . " at " . date("H:i", strtotime($talk->start));
            $talks[$index]['speaker'] = $talk->speaker;
            $talks[$index]['abstract'] = $talk->abstract;
            $talks[$index]['venue'] = $talk->venue;
            $index++;
        }

        return view('talks.index', compact('talks'));
    }

}
