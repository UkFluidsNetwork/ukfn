<?php

namespace App\Http\Controllers;

use SEO;
use App\Talk;
use App\Aggregator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\TalksFormRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

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
     *
     * @return Illuminate\Support\Facades\View
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
     *
     * @param intiger $id
     * @return Illuminate\Support\Facades\View
     */
    public function view($id)
    {
        $nonFormatedtalk = Talk::findOrFail($id);
        $talk = self::formatTalks([$nonFormatedtalk])[0];

        return view('talks.view', compact('talk'));
    }

    /**
     * Update all talks
     *
     * @return void
     */
    public static function updateTalks()
    {
        $aggregators = Aggregator::all();

        foreach ($aggregators as $aggregator) {
            if (!filter_var($aggregator->url, FILTER_VALIDATE_URL)) {
                continue;
            }

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
                        $talk->title = $value->title !== $talk->title && $value->title !== "" ? $value->title : $talk->title;
                        $talk->speaker = $value->speaker !== $talk->speaker && $value->speaker !== "" ? $value->speaker : $talk->speaker;
                        $talk->start = Carbon::createFromFormat('D, d M Y H:i:s e', $value->start_time)->format('Y-m-d H:i:s')
                            !== $talk->start && Carbon::createFromFormat('D, d M Y H:i:s e', $value->start_time)->format('Y-m-d H:i:s')
                            ? Carbon::createFromFormat('D, d M Y H:i:s e', $value->start_time)->format('Y-m-d H:i:s')
                            : $talk->start;
                        $talk->end = Carbon::createFromFormat('D, d M Y H:i:s e', $value->end_time)->format('Y-m-d H:i:s')
                            !== $talk->end && Carbon::createFromFormat('D, d M Y H:i:s e', $value->end_time)->format('Y-m-d H:i:s')
                            ? Carbon::createFromFormat('D, d M Y H:i:s e', $value->end_time)->format('Y-m-d H:i:s')
                            : $talk->end;
                        $talk->url = $value->url !== $talk->url && $value->url !== "" ? $value->url : $talk->url;
                        $talk->speakerurl = $value->speaker_url !== $talk->speaker_url && $value->speaker_url !== "" ? $value->speaker_url : $talk->speaker_url;
                        $talk->venue = $value->venue !== $talk->venue && $value->venue !== "" ? $value->venue : $talk->venue;
                        $talk->organiser = $value->organiser;
                        $talk->series = $value->series;
                        $talk->aggregator_id = $aggregator->id;
                        $talk->abstract = $value->abstract;
                        $talk->message = $value->special_message;
                        $talk->created_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->created_at)->format('Y-m-d H:i:s');
                        $talk->updated_at = Carbon::createFromFormat('D, d M Y H:i:s e', $value->updated_at)->format('Y-m-d H:i:s');
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
                            $talk->title = $value->title !== $talk->title && $value->title !== "" ? $value->title : $talk->title;
                            $talk->speaker = $value->summary !== $talk->summary && $value->summary !== "" ? $value->summary : $talk->summary;
                            $talk->start = Carbon::parse($imperialnewsevents->event_start_date) !== $talk->start 
                                && Carbon::parse($imperialnewsevents->event_start_date) !== "" 
                                ? Carbon::parse($imperialnewsevents->event_start_date) : $talk->start;
                            $talk->end = Carbon::parse($imperialnewsevents->event_end_date) !== $talk->end
                                && Carbon::parse($imperialnewsevents->event_end_date) !== "" 
                                ? Carbon::parse($imperialnewsevents->event_end_date) : $talk->end;
                            $talk->url = $value->id;
                            $talk->venue = $imperialnewsevents->source . ", " . $imperialnewsevents->location !== $talk->venue 
                                && ($imperialnewsevents->source && $imperialnewsevents->location) 
                                ? $imperialnewsevents->source . ", " . $imperialnewsevents->location
                                : $talk->venue;
                            $talk->aggregator_id = $aggregator->id;
                            $talk->organiser = $imperialnewsevents->source;
                            $talk->created_at = Carbon::parse($value->published);
                            $talk->updated_at = Carbon::parse($value->updated);
                            $talk->save();
                        }
                    }
                    break;
            }
        }
    }

    /**
     * Exclude exceptions and format the date of the remaining ones
     *
     * @param array $rawTalks
     * @return array
     */
    public static function formatTalks($rawTalks)
    {
        $talks = [];
        $index = 0;
        foreach ($rawTalks as $talk) {
            if (in_array($talk->title, static::$exceptions)) {
                continue;
            }

            // we instantiate a talk object in case $talk is a std object
            // rather than actual intance of Talk,
            // otherwise we cannnot use functions in the Talk class
            $talk = Talk::findOrFail($talk->id);
            $talks[$index] = $talk;
            $talks[$index]->aggregator = $talk->aggregator_id
                ? Aggregator::findOrFail($talk->aggregator_id)
                : null;
            $talks[$index]->isRecorded = $talk->isRecorded();
            $talks[$index]->isStreamed = $talk->isStreamed();
            $talks[$index]->displayStream = $talk->displayStream();
            $talks[$index]->displayRecording = $talk->displayRecording();
            $talks[$index]->isFuture = $talk->isFuture();
            $talks[$index]->when = PagesController::formatDate($talk->start);
            $index++;
        }

        return $talks;
    }

    /**
     * Generate the page description for the talks section
     *
     * @return string
     */
    private static function getSEODescription()
    {
        $description = 'Fluids-related seminars and talks in the UK, '
                     . 'imported from the ';

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
     * Get all current, past, or recorded talks in JSON
     *
     * @param string $query
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllJson($query, Request $request)
    {
        $queriesAllowed = ["future", "past", "recorded"];
        $parameters = $request->all();
        $feeds = isset($parameters['feeds']) && $parameters['feeds'] !== "[]"
            ? json_decode($parameters['feeds'])
            : null;
        $terms = isset($parameters['search'])&& $parameters['search'] !== "[]"
            ? json_decode($parameters['search'])
            : null;

        if (!in_array($query, $queriesAllowed)) {
            return response()->json('Invalid query', 500);
        }

        switch ($query) {
            case "future":
                $bareTalks = Talk::getFutureTalks($feeds);
                break;
            case "past":
                $bareTalks = Talk::getPastTalks($feeds);
                break;
            case "recorded":
                $bareTalks = Talk::getRecordedTalks($terms);
                break;
        }
        $talks = self::formatTalks($bareTalks);
        return response()->json($talks);
    }

    /**
     * Set the generic SEO description for talks
     *
     * @return void
     */
    private static function setSEODescription()
    {
        SEO::setDescription(self::getSEODescription());
    }

    /**
     * View all current talks in Admin Panel
     *
     * @return Illuminate\Support\Facades\View
     */
    public function talksList()
    {
        $allTalks = Talk::all();
        $talks = self::formatTalks($allTalks);

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Talks', 'path' => '/panel/talks']
        ];

        $breadCount = count($bread);

        return view('panel.talks.list', compact(
            'talks', 'bread', 'breadCount'));
    }

    /**
     * Add new talk
     *
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'Talks', 'path' => '/panel/talks'],
                ['label' => 'Add', 'path' => '/panel/talks/add'],
        ];
        $breadCount = count($bread);

        $talk = new Talk();
        $aggregators = AggregatorsController::getSelect();
        $institutions = InstitutionsController::getSelect();

        return view('panel.talks.add', compact(
            'talk', 'bread', 'breadCount', 'aggregators', 'institutions'));
    }

     /**
     * Create new talk
     *
     * @param TalksFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     *
     * @param type $id
     * @param TalkUpdateRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     * Edit talks
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Talks', 'path' => '/panel/talks'],
            ['label' => 'Edit', 'path' => '/panel/talks/edit'],
        ];

        $breadCount = count($bread);

        $talk = Talk::findOrFail($id);
        $aggregators = AggregatorsController::getSelect();
        $institutions = InstitutionsController::getSelect();

        return view('panel.talks.edit', compact(
            'talk', 'aggregators', 'bread', 'breadCount', 'institutions'));
    }

    /**
     * Set up to test SMS streaming facility.
     *
     * @todo if it works, embed the code within /talks and /talks:id,
     * otherwise remove
     * @return \Illuminate\View\View
     */
    public function stream()
    {
        return view('talks.stream');
    }
}
