<?php

namespace App\Http\Controllers;

use SEO;
use App\Talk;
use Carbon\Carbon;

class TalksController extends Controller
{

    private static $talksRSS = [
        [
            'name' => 'Cambridge Fluids Network - fluids-related seminars',
            'path' => 'http://talks.cam.ac.uk/show/xml/54169',
            'aggr' => 'talks.cam'
        ],
        [
            'name' => 'Imperial College Turbulence Seminar',
            'path' => 'http://www3.imperial.ac.uk/imperialnewsevents/eventsfront?pid=69_189112051_69_189111978_189111978',
            'aggr' => 'lonimperial'
        ],
    ];
    private static $exceptions = [
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
    public function index()
    {
        SEO::setTitle('Talks');
        self::setSEODescription();

        $talksRSS = static::$talksRSS;
        $talksMenu = $this->talksWeekMenu();

        return view('talks.index', compact('talksRSS', 'talksMenu'));
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
        $talksMenu = $this->talksWeekMenu();

        $talk = Talk::findOrFail($id);
        $talk->when = date("l jS F", strtotime($talk->start)) . " at " . date("H:i", strtotime($talk->start));

        return view('talks.view', compact('talk', 'talksMenu'));
    }

    /**
     * View all talks
     * @return view
     * @author Robert Barczyk <robert@barczyk.net>
     * @access public
     */
    public function viewAll()
    {
        SEO::setTitle('Talks');
        self::setSEODescription();

        $allTalks = Talk::getAllCurrentTalks();
        $talks = self::formatTalks($allTalks);

        $talksMenu = $this->talksWeekMenu();

        return view('talks.viewall', compact('talksMenu', 'talks'));
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

        if (empty($weeklyTalks)) {
            $weeklyTalks = Talk::getUpcomingTalks();
            $menuHeader = "Upcoming talks";
        }

        $talksMenu = self::formatTalks($weeklyTalks);

        return [
            "talks" => $talksMenu,
            "header" => $menuHeader
        ];
    }

    /**
     * Update all talks
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function updateTalks()
    {
        foreach (static::$talksRSS as $rss) {
            $xml = simplexml_load_file($rss['path']);

            switch ($rss['aggr']) {
                case 'talks.cam' :
                    foreach ($xml->talk as $value) {
                        $existingTalk = Talk::findByTalkid($value->id);

                        if (empty($existingTalk)) {
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

                            $existingTalk = Talk::findByTalkid($imperialnewsevents->articleid);

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

    /**
     * Exclude exceptions and format the date of the remaining ones
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @static
     * @param array $talks
     * @param string $dateFormat
     * @return array
     */
    public static function formatTalks($talks, $dateFormat = "l jS F")
    {
        $formattedTalks = [];
        $index = 0;
        foreach ($talks as $talk) {
            if (in_array($talk->title, static::$exceptions)) {
                continue;
            }
            $formattedTalks[$index] = $talk;
            $formattedTalks[$index]->when = date($dateFormat, strtotime($talk->start)) . " at " . date("H:i", strtotime($talk->start));
            $index++;
        }

        return $formattedTalks;
    }

    /**
     * Genereate the page description for the talks section
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access private
     * @static
     * @return string
     */
    private static function getSEODescription()
    {
        $description = 'Fluids-related seminars and talks in the UK, imported from the ';
        foreach (static::$talksRSS as $key => $feed) {
            $description.= $feed['name'];
            if ($key + 1 < count(static::$talksRSS) - 1) {
                $description .= ', ';
            } elseif ($key + 1 === count(static::$talksRSS) - 1) {
                $description .= ', and ';
            }
        }
        $description.= ' RSS Feeds';
        return $description;
    }
    
    /**
     * Set the generic SEO description for talks
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access private
     * @static
     * @return void
     */
    private static function setSEODescription()
    {
        SEO::setDescription(self::getSEODescription());
    }
}
