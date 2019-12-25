<?php

namespace App\Http\Controllers;

use Auth;
use Cache;
use SEO;
use App\Connectbox;
use Illuminate\Http\Request;
use App\Http\Requests\ResourceFormRequest;
use App\Http\Requests\ConnectBoxRequest;
use App\Http\Requests\TutorialFileFormRequest;
use Illuminate\Support\Facades\Session;

class ConnectController extends Controller
{
    private static $connectPanelCrumbs = [
        ['label' => 'Panel', 'path' => '/panel'],
        ['label' => 'Connect', 'path' => '/panel/connect']
    ];

    public function view()
    {
        $bread = static::$connectPanelCrumbs;
        $breadCount = count($bread);

        $boxes = Connectbox::orderBy('order')->get();
        foreach ($boxes as $box) {
            $box->created = date("d M H:i",
                strtotime($box->created_at));
            $box->updated = date("d M H:i",
                strtotime($box->updated_at));
        }
        return view('panel.connect.view',
            compact('boxes', 'bread', 'breadCount'));
    }

    public function add()
    {
        $bread = array_merge(static::$connectPanelCrumbs,
                             [['label' => 'Add',
                               'path' => "/panel/connect/add"]]);
        $breadCount = count($bread);

        $box = new Connectbox;
        return view('panel.connect.addbox',
                    compact('box', 'bread', 'breadCount'));
    }

    /**
     * Create sig box
     *
     * @param SigBoxRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function createBox(ConnectBoxRequest $request)
    {
        try {
            $connectBox = new Connectbox;
            $input = $request->all();
            $connectBox->fill($input);
            $connectBox->save();

            Session::flash('success_message', 'Added succesfully. '
                . 'Boxes are disabled by default. Click on enable '
                . 'to have them displayed on the Connect page.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/connect');
    }
}
