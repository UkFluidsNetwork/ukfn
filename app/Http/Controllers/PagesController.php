<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    public function contact()
    {
        //$name = 'Robert BArczyk';
        //return view('pages.about')->with('name', $name);

        //return view('pages.about')->with([
          // 'first' => 'Robert',
           // 'last' => 'Barczyk'
       // ]);

        //$data = [];
        //$data['first'] = "Fox";
        //$data['last'] = "Moulder";

       // return view('pages.about', $data);

        //$people = ['Michał', 'Ewelina'];
        //$people = [];
        // Or we use compact
        //$first = 'Fox1';
       // $last = 'Moulder';

        //return view('pages.contact', compact('first', 'last'), compact('people'));
        return view('pages.contact');
    }

}
