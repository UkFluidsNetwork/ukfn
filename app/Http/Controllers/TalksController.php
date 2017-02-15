<?php

namespace App\Http\Controllers;

use SEO;
use App\Talk;
use App\Aggregator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\TalksFormRequest;

class TalksController extends Controller
{

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

        $talksRSS = Aggregator::all();

        return view('talks.index', compact('talksRSS'));
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
        $talk = Talk::findOrFail($id);
        $talk->when = date("l jS F", strtotime($talk->start)) . " at " . date("H:i", strtotime($talk->start));
        
        $aggregator = Aggregator::findOrFail($talk->aggregator_id);
        
        $displayRecording = self::displayRecording($talk->recordinguntil);
        $displayStreaming = self::displayRecording($talk->start, $talk->end, true);
        
        return view('talks.view', compact('talk', 'displayRecording', 'displayStreaming', 'aggregator'));
    }

    /**
     * Update all talks
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function updateTalks()
    {
        $aggregators = Aggregator::all();
        
        foreach ($aggregators as $aggregator) {
            $xml = simplexml_load_file($aggregator->url);

            switch ($aggregator->id) {
                // TALKS CAM FLUIDS
                case '1' :
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
                        $talk->aggregator_id = $aggregator->id;
                        $talk->abstract = $value->abstract;
                        $talk->message = $value->special_message;
                        $talk->created_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->created_at)->format('Y-m-d H:i:s');
                        $talk->updated_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->updated_at)->format('Y-m-d H:i:s');
                        $talk->deleted = 0;
                        $talk->save();
                    }

                    break;
                // LON IMPERIAL
                case '2' :
                case '3' :
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
                            $talk->aggregator_id = $aggregator->id;
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
            $formattedTalks[$index]->aggregator = Aggregator::findOrFail($talk->aggregator_id);
            $formattedTalks[$index]->displayRecording = self::displayRecording($talk->recordinguntil);     
            $formattedTalks[$index]->displayStreaming = self::displayRecording($talk->start, $talk->end, true);
            $formattedTalks[$index]->when = date($dateFormat, strtotime($talk->start)) . " at " . date("H:i", strtotime($talk->start));
            $index++;
        }

        return $formattedTalks;
    }

    /**
     * Generate the page description for the talks section
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access private
     * @static
     * @return string
     */
    private static function getSEODescription()
    {
        $description = 'Fluids-related seminars and talks in the UK, imported from the ';
        
        $talksRSS = Aggregator::all();
        
        foreach ($talksRSS as $key => $feed) {
            $description.= $feed->name;
            if ($key + 1 < count($talksRSS) - 1) {
                $description .= ', ';
            } elseif ($key + 1 === count($talksRSS) - 1) {
                $description .= ', and ';
            }
        }
        $description.= ' RSS Feeds';
        return $description;
    }
    
    /**
     * Pass first param only as date to get bool value of until what time recording / streaming icon and embeded video should appear
     * 2nd and 3rd parameter are for streaming only. Stream video will appear 15 minutes before and after scheduled time start/end  
     * @param string $dateStart
     * @param string $dateEnd
     * @param bool $stream
     * @return boolean
     * @author Robert Barczyk <rb783@cam.ac.uk>
     * @access public
     * @static
     */
    public static function displayRecording($dateStart, $dateEnd = false, $stream = false)
    {
        if ($dateStart !== null) {
            $recordinguntil = Carbon::parse($dateStart);
        } else {
            return false;
        }
        
        if ($stream) { 
            $streamingStart = Carbon::parse($dateStart);
            $streamingEnd = Carbon::parse($dateEnd);
                            
            if(Carbon::now() >= $streamingStart->addMinutes(-15) && Carbon::now() <= $streamingEnd->addMinutes(15)) {            
                return true;
            } else {
                return false;
            }
        } else {
            $today = Carbon::today();

            $dateDiff = $today->diff($recordinguntil);
            
            if ($dateDiff->invert === 0) {
                return true;
            } else {
                return false;
            }
        }        
    }
    
    /**
     * Get all talks from today 
     * @author Robert Barczyk <robert@barczyk.net>
     * @return Json
     */
    public function getAllJson()
    {
        $allTalks = Talk::getAllCurrentTalks();
        $talks = self::formatTalks($allTalks);
        return response()->json($talks);
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
    
    /**
     * View all current talks in Admin Panel
     * @author Robert Barczyk <robert@barczyk.net>
     * @access public
     * @return void
     */
    public function panelViewCurrent()
    {
        $allTalks = Talk::getAllCurrentTalks(true);   
        $talks = self::formatTalks($allTalks);
                        
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Talks', 'path' => '/panel/talks']
        ];
        
        $breadCount = count($bread);
        
        return view('panel.talks.viewcurrent', compact('talks', 'bread', 'breadCount'));
    } 
    
    
    /**
     * Add new talk
     * @author Robert Barczyk <robert@barczyk.net>
     * @access public
     * @return void
     */
    public function add()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'Talks', 'path' => '/panel/talks'],
                ['label' => 'Add', 'path' => '/panel/talks/add'],
        ];
        $breadCount = count($bread);

        $talk = new Talk();
        $aggregators = AggregatorsController::getSelect();
        $institutions = InstitutionsController::getSelect();
        
        return view('panel.talks.add', compact('talk', 'bread', 'breadCount', 'aggregators', 'institutions'));
    }
    
     /**
     * Create new talk
     * @author Robert Barczyk <robert@barczyk.net>
     * @param TalksFormRequest $request
     * @return void
     */
    public function create(TalksFormRequest $request)
    {
        try {
            $talk = new Talk();
            $input = $request->all();
            $talk->fill($input);
            $talk->save();

            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        return redirect('/panel/talks/');
    }
       
    /**
     * Update selected talk
     * @param type $id
     * @param TalkUpdateRequest $request
     * @return void
     * @author Robert Barczyk <rb783@cam.ac.uk>
     */
    public function update($id, TalksFormRequest $request)
    {
        try {
            $talk = Talk::findOrFail($id);
            $input = $request->all();
            
            $talk->recordingurl = $request->input('recordingurl');
            $talk->streamingurl = $request->input('streamingurl');
            $talk->teradekip = $request->input('teradekip');
            
            if ($request->input('recordinguntil') != '') {
                $talk->recordinguntil = $request->input('recordinguntil');    
            } else {
                $talk->recordinguntil = null;    
            }

            $talk->fill($input);
            $talk->save();
            
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/talks');
    }
    
    /**
     * Edit news
     * @access public
     * @param int $id
     * @return void
     * @author Robert Barczyk <rb783@cam.ac.uk>
     */
    public function edit($id)
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Talks', 'path' => '/panel/talks'],
            ['label' => 'Edit', 'path' => '/panel/talks/edit'],
        ];
        
        $breadCount = count($bread);

        $talk = Talk::findOrFail($id);
        $aggregators = AggregatorsController::getSelect();
        $institutions = InstitutionsController::getSelect();

        return view('panel.talks.edit', compact('talk', 'aggregators', 'bread', 'breadCount', 'institutions'));
    }

    /**
     * Delete selected talk via admin panel
     * @author Robert Barczyk <robert@barczyk.net>
     * @param intiger $id aggregator id
     * @return void
     */
    public function delete($id)
    {
        try {
            $talk = Talk::findOrFail($id);
            $talk->deleted = 1;
            $talk->save();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/talks');
    }
}
