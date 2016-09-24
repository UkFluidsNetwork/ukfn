<?php

namespace App\Http\Controllers;

use SEO;

class AdminController extends Controller
{

    public function index()
    {
        SEO::setTitle('Admin');
        SEO::setDescription('Find more about the grants that support UKFN, '
            . 'the proposal documents, minutes of the meetings held by the panel, a list of institutional points of contact,'
            . 'and a summary of the emails we send to our mailing list.');
        
        $listEmails = [
            0 => [
                "id" => 1,
                "date" => "Wednesday 21st September",
                "subject" => "First bulleting",
            ],
            1 => [
                "id" => 2,
                "date" => "Friday 23rd September",
                "subject" => "Second bulleting",
            ]
        ];
        $publicEmails = [
            0 => [
                "id" => 1,
                "date" => "Thurdsaday 1st September",
                "subject" => "ukfluids.net launch",
            ],
            1 => [
                "id" => 2,
                "date" => "Friday 9th September",
                "subject" => "Launch event was a success!",
            ]
        ];

        return view('admin.index', compact('listEmails', 'publicEmails'));
    }
}
