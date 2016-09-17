<?php

namespace App\Http\Controllers;

use App\Sig;
use App\Suggestion;
use DateTime;
use SEO;

class SigsController extends Controller
{

    public function index()
    {
        SEO::setTitle('Special Interest Groups');
        SEO::setDescription('UKFN is pleased to invite proposals for the first round of Special Interest Groups. '
            . 'The call is open to anyone working in fluid mechanics in the UK. ');

        $allSuggestions = Suggestion::getAllSuggestions();
        $newCount = 0;

        foreach ($allSuggestions as $suggestion) {
            // create datetime objects for created_at and today
            $created_at = new DateTime($suggestion->created_at);
            $today = new DateTime();
            // suggestions older than 7 days will be marked as new.
            $difference = (int) $today->diff($created_at)->format('%R%a');
            if ($difference >= -7 && $difference <= 0) {
                $suggestion->new = "<span class='badge badge-success'>new</span>";
                $newCount++;
            } else {
                $suggestion->new = "";
            }
        }

        return view('sig.index', compact('allSuggestions', 'newCount'));
    }
}
