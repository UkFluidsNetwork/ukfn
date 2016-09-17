<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Talk;
use App\Http\Requests;
use SEO;

class TalksController extends Controller
{

    public function index()
    {
        SEO::setTitle('Talks');
        SEO::setDescription('Feed of fluids-related seminars in the UK.'
            . ' Currently all talks are imported from the  Cambridge Fluids Network - fluids-related seminars RSS feed. '
            . 'To link another RSS feed to this page, please contact us.');

        $exceptions = ["TBC", "tbc", "To be confirmed", "Title to be confirmed", "TBD"];

        $talks = [];
        $index = 0;
        Talk::updateTalks();
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
