<?php

namespace App\Http\Controllers;

use App\Talk;
use DB;
use Carbon\Carbon;
use SEO;

class TalksController extends Controller {

    private $talksRSS = 
            [
                [
                    'name' => 'Cambridge Fluids Network - fluids-related seminars',
                    'path' => 'http://talks.cam.ac.uk/show/xml/54169',
                    'aggr' => 'talks.cam'
                ],
                [
                    'name' => 'Imperial College Turbulence Seminar ',
                    'path' => 'http://www3.imperial.ac.uk/imperialnewsevents/eventsfront?pid=69_189112051_69_189111978_189111978',
                    'aggr' => 'lonimperial'                    
                ],
            ];
    
    private $exceptions = 
        [
            "TBC",
            "tbc",
            "To be confirmed",
            "Title to be confirmed",
            "TBD"
        ];
    
    /**
     * Talks main page
     * @return view
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function index() {
        SEO::setTitle('Talks');
        SEO::setDescription('Feed of fluids-related seminars in the UK.'
                . ' Currently all talks are imported from the  Cambridge Fluids Network - fluids-related seminars RSS feed. '
                . 'To link another RSS feed to this page, please contact us.');

        $talksRSS = $this->talksRSS;
        //$this->updateTalks();
                 
        $talksMenuAll = $this->talksWeekMenu();
        $talksMenu = $talksMenuAll['talksMenu'];
        $menuHeader = $talksMenuAll['menuHeader'];
                
        return view('talks.index', compact('talksRSS', 'talksMenu', 'menuHeader'));
    }
    
    /**
     * View Talk
     * @param intiger $id
     * @return view
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function view($id)
    {                  
        $talksMenuAll = $this->talksWeekMenu();
        $talksMenu = $talksMenuAll['talksMenu'];
        $menuHeader = $talksMenuAll['menuHeader'];
        
        $t = Talk::findOrFail($id);
        
        $talk = [
            "id" => $t->id,
            "title" => $t->title,
            "speaker" => $t->speaker,
            "aggregator" => $t->aggregator,
            "when" => date("l jS F", strtotime($t->start)) . " at " . date("H:i", strtotime($t->start)),
            "venue" => $t->venue,
            "abstract"=> $t->abstract,
            "recordingurl" => $t->recordingurl    
        ];
        
        return view('talks.view', compact('talk', 'talksMenu', 'menuHeader'));
    }
    
    /**
     * View all talks
     * @return view
     * @author Robert Barczyk <robert@barczyk.net>
     * @access public
     */
    public function viewAll()
    {   
        $talks = [];
        $index = 0;
        $allTalks = Talk::getAllCurrentTalks();

        foreach ($allTalks as $talk) {
            if (in_array($talk->title, $this->exceptions)) {
                continue;
            }
            
            $talks[$index]['title'] = $talk->title;
            $talks[$index]['when'] = date("l jS F", strtotime($talk->start)) . " at " . date("H:i", strtotime($talk->start));
            $talks[$index]['start'] = $talk->start;
            $talks[$index]['end'] = $talk->end;
            $talks[$index]['speaker'] = $talk->speaker;
            $talks[$index]['aggregator'] = $talk->aggregator;
            $talks[$index]['abstract'] = $talk->abstract;
            $talks[$index]['venue'] = $talk->venue;
            $talks[$index]['recordingurl'] = $talk->recordingurl;
            $index++;
        }
                
        $talksMenuAll = $this->talksWeekMenu();
        $talksMenu = $talksMenuAll['talksMenu'];
        $menuHeader = $talksMenuAll['menuHeader'];
        
        return view('talks.viewall', compact('talksMenu', 'menuHeader', 'talks'));
    }

    /**
     * Get menu talks menu items
     * @return array    ['talksMenu'] = array, ['menuHeader'] = string
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function talksWeekMenu()
    {
        $weeklyTalks = Talk::getTalksThisWeek();
        $menuHeader = "Talks this week";
        
        if (empty($weeklyTalks)) {
            $weeklyTalks = Talk::getTalksNextWeek();
            $menuHeader = "Talks next week";
        }
        
        $talksMenu = [];
        $i = 0;
        
        foreach ($weeklyTalks as $talk) {
            if (in_array($talk->title, $this->exceptions)) {
                continue;
            }
            
            $talksMenu[$i]['id'] = $talk->id;
            $talksMenu[$i]['title'] = $talk->title;
            $talksMenu[$i]['speaker'] = $talk->speaker;
            $talksMenu[$i]['venue'] = $talk->venue;
            $talksMenu[$i]['when'] = date("l jS F", strtotime($talk->start)) . " at " . date("H:i", strtotime($talk->start));
            $i++;
        }
        
        return [
            "talksMenu" => $talksMenu, 
            "menuHeader" => $menuHeader
            ];
    }
    
    /**
     * Update all talks
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function updateTalks()
    {
        foreach ($this->talksRSS as $rss) {
            $xml = simplexml_load_file($rss['path']);
            
            switch ($rss['aggr']) {
                case 'talks.cam' :
                    foreach ($xml->talk as $value) {
                        $existingTalk = DB::table('talks')->where('talkid', '=', $value->id)->get();
                        
                        if(empty($existingTalk)) {
                            $talk = new Talk();
                        } else {
                            $talk = Talk::find($existingTalk[0]->id);
                        }

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
                        $talk->aggregator = 'Cambridge Fluids Network';
                        $talk->abstract = $value->abstract;
                        $talk->message = $value->special_message;
                        $talk->created_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->created_at)->format('Y-m-d H:i:s');
                        $talk->updated_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->updated_at)->format('Y-m-d H:i:s');
                        $talk->deleted = 0;
                        $talk->save();
                    }
                    
                    break;
                case 'lonimperial' :
                    foreach ($xml as $value) {
                        // skip empty object at the begining of RSS feed
                        if ($value->id) {
                            $namespaces = $value->getNamespaces(true);
                            $imperialnewsevents = $value->children($namespaces["imperialnewsevents"]);

                            $existingTalk = DB::table('talks')->where('talkid', '=', $imperialnewsevents->articleid)->get();
                            
                            if (empty($existingTalk)) {
                                $talk = new Talk();
                            } else {
                                $talk = Talk::find($existingTalk[0]->id);
                            }

                            $talk->talkid = $imperialnewsevents->articleid;
                            $talk->title = $value->title;
                            $talk->speaker = $value->summary;
                            $talk->start = Carbon::parse($imperialnewsevents->event_start_date);
                            $talk->end = Carbon::parse($imperialnewsevents->event_end_date);
                            $talk->url = $value->id;
                            $talk->venue = $imperialnewsevents->source . ", " . $imperialnewsevents->location;
                            $talk->aggregator = 'Imperial College Turbulence Seminar';
                            $talk->organiser = $imperialnewsevents->source;
                            $talk->created_at = Carbon::parse($value->published);
                            $talk->updated_at = Carbon::parse($value->updated);
                            $talk->deleted = 0;
                            $talk->save();
                        }
                    }
                    break;
            }
        }
    }
}
