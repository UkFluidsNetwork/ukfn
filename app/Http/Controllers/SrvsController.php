<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use SEO;

class SrvsController extends Controller
{

    public function index()
    {
        SEO::setTitle('Short Research Visits');
        SEO::setDescription('UKFN is pleased to invite proposals for SRVs. The call is open to anyone working in fluid mechanics in the UK.');

        return view('srv.index');
    }
}
