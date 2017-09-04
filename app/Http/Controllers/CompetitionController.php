<?php

namespace App\Http\Controllers;

use DB;
use SEO;
use App\Vote;
use App\Competitionentry;
use App\Http\Requests\VoteRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class CompetitionController extends Controller
{

    /**
     * Render a page with information about the competition
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        SEO::setTitle('Photo & video Competition');
        SEO::setDescription('The UK Fluids Network is launching a competition'
              . ', open to all UK-based fluids researchers, for the best'
              . ' new photo and video in Fluid Mechanics.');

        return view('competition.index');
    }

    /**
     * Render the voting interface for the copetition
     *
     * @param string $type Type of entries to display: photo or videos
     * @return Illuminate\Support\Facades\View
     */
    public function displayEntries($type)
    {
        $entries = Competitionentry::all();
        if ($type === "photos") {
            $title = "Photo";
        } elseif ($type === "videos") {
            $title = "Video";
        } else {
            abort(404);
        }

        $name = strtolower($title);
        SEO::setTitle("{$title} Entries - Photo & Video Competition");
        SEO::setDescription("Vote for the best {$type} in Fluid Mechanics");

        return view('competition.entries', compact('entries', 'name', 'title'));
    }

    /**
     * Register the vote
     *
     * @param VoteRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function vote(VoteRequest $request)
    {
        $input = $request->all();
        $vote  = new Vote();
        $vote->fill($input);
        if ($vote->isValid()) {
            $vote->save();
            session::flash('vote_ok', 'Thank you for your vote.');
        } else {
            Session::flash('duplicate_vote', 'Only one vote is allowed.');
        }

        return Redirect::to(URL::previous());
    }

    /**
     * Render the winner interface for the competition
     *
     * @param string $type Type of entries to display: photo or videos
     * @return Illuminate\Support\Facades\View
     */
    public function displayWinners($type)
    {
        $entriesIds = Competitionentry::winnersIds();
        if ($type === "photos") {
            $title = "Photo";
        } elseif ($type === "videos") {
            $title = "Video";
        } else {
            abort(404);
        }

        $entries = [];
        // transform std objects into Competitionentry objects
        foreach ($entriesIds as $entry) {
            $entries[] = Competitionentry::findOrFail($entry->id);
        }

        $name = strtolower($title);
        SEO::setTitle("{$title} Entries - Photo & Video Competition");
        SEO::setDescription("Vote for the best {$type} in Fluid Mechanics");

        return view('competition.winner', compact('entries', 'name', 'title'));
    }
}

