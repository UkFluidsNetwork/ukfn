<?php

namespace App\Http\Controllers;

use SEO;

class CompetitionController extends Controller
{

    public function index()
    {
        SEO::setTitle('Photo & video Competition');
        SEO::setDescription('The UK Fluids Network is launching a competition'
              . ', open to all UK-based fluids researchers, for the best'
              . ' new photo and video in Fluid Mechanics.');

        return view('competition.index');
    }
}
