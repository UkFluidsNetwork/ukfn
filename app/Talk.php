<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
//  protected $fillable = [
//      'talkid',
//      'title',
//      'speaker',
//      'start',
//      'end',
//      'url',
//      'speakerurl',
//      'venue',
//      'organiser',
//      'series',
//      'aggregator',
//      'abstract',
//      'message',
//      'deleted'
//    ];
  /**
   * Function fetch talks and store it in local DB
   * DEV NOTE - TRY CATCH NEEDS TO BE ADDED FOR SQL AND XML
   * 
   * @author Robert Barczyk <robert@barczyk.net>
   */
  public static function updateTalks()
  {
    $xmlLink = "http://talks.cam.ac.uk/show/xml/54169";
    
    $talkAggregator = simplexml_load_file($xmlLink);
   
        
    foreach ($talkAggregator->talk as $value) {
      $existingTalk = \DB::table('talks')->where('talkid', '=', $value->id)->get();
      
      // Insedrt new record if fetched talk doesn't exist in out DB 
      if (empty($existingTalk)) {
        // create talk object and assign attributes
        $talk                   = new Talk();
        $talk->talkid           = $value->id;
        $talk->title            = $value->title;
        $talk->speaker          = $value->speaker;
        $talk->start            = \Carbon\Carbon::createFromFormat('D, d M Y H:i:s e', $value->start_time)->format('Y-m-d H:i:s');
        $talk->end              = \Carbon\Carbon::createFromFormat('D, d M Y H:i:s e', $value->end_time)->format('Y-m-d H:i:s');
        $talk->url              = $value->url;
        $talk->speakerurl       = $value->speaker_url;
        $talk->venue            = $value->venue;
        $talk->organiser        = $value->organiser;
        $talk->series           = $value->series;
        $talk->aggregator       = $talkAggregator->id;
        $talk->abstract         = $value->abstract;
        $talk->message          = $value->special_message;
        $talk->created_at       = \Carbon\Carbon::createFromFormat('D, d M Y H:i:s e', $value->created_at)->format('Y-m-d H:i:s');
        $talk->updated_at       = \Carbon\Carbon::createFromFormat('D, d M Y H:i:s e', $value->updated_at)->format('Y-m-d H:i:s');
        $talk->deleted          = 0;
        // save to DB
        $talk->save();
      } 
      // Otherwise update existing one
      else {
        $talk                   = new Talk();
        $talk->talkid           = $value->id;
        $talk->title            = $value->title;
        $talk->speaker          = $value->speaker;
        $talk->start            = \Carbon\Carbon::createFromFormat('D, d M Y H:i:s e', $value->start_time)->format('Y-m-d H:i:s');
        $talk->end              = \Carbon\Carbon::createFromFormat('D, d M Y H:i:s e', $value->end_time)->format('Y-m-d H:i:s');
        $talk->url              = $value->url;
        $talk->speakerurl       = $value->speaker_url;
        $talk->venue            = $value->venue;
        $talk->organiser        = $value->organiser;
        $talk->series           = $value->series;
        $talk->aggregator       = $talkAggregator->id;
        $talk->abstract         = $value->abstract;
        $talk->message          = $value->special_message;
        $talk->created_at       = \Carbon\Carbon::createFromFormat('D, d M Y H:i:s e', $value->created_at)->format('Y-m-d H:i:s');
        $talk->updated_at       = \Carbon\Carbon::createFromFormat('D, d M Y H:i:s e', $value->updated_at)->format('Y-m-d H:i:s');
        $talk->deleted          = 0;
        $talk->update();
      }
    }
  }
  
  public static function getAllTalks()
  {
    $talks = \DB::table('talks')->orderBy('start', 'ASC')->get();

    return $talks;
  }
}
