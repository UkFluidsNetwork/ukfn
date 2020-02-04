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
     * @param connectBoxRequest $request
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

        /**
     * Render connect box edit interface
     *
     * @param int $id sig box ID
     * @return Illuminate\Support\Facades\View
     */
     public function editBox($id)
    {
        $connectBox = Connectbox::findOrFail($id);
        $bread = array_merge(static::$connectPanelCrumbs,
                                [['label' => 'Edit',
                                  'path' => "/panel/connect/edit/${id}"]]);

        $breadCount = count($bread);

        return view('panel.connect.editbox',
                    compact('connectBox', 'bread', 'breadCount'));
    }


    /**
     * Update sig box
     *
     * @param int $id box id
     * @param ConnectBoxRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
     public function updateBox($id, ConnectBoxRequest $request)
    {
        try {
            $connectBox = ConnectBox::findOrFail($id);
            $input = $request->all();
            $connectBox->fill($input);
            $connectBox->save();
            Session::flash('success_message', 'Updated succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/connect');
    }

        /**
     * Change the order of a connect box
     *
     * @param string $direction up/down
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
     public function moveBox($direction, $id)
    {
        try {
            $connectBox = ConnectBox::findOrFail($id);
            if ($direction === "up") {
                $connectBox->order--;
            } else {
                $connectBox->order++;
            }
            $connectBox->save();
            Session::flash('success_message', 'Moved succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/connect');
    }

        /**
     * Enable/disable a course
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
     public function toggleBoxStatus($id)
    {
        try {
            $connectBox = ConnectBox::findOrFail($id);
            if ($connectBox->status() === "Enabled") {
                $connectBox->active = 0;
            } else {
                $connectBox->active = 1;
            }
            $connectBox->save();
            Session::flash('success_message', $connectBox->status()
                                              . ' succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/connect/');
    }

        /**
     * Delete connect boxes
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
     public function deleteBox($id)
    {
        try {
            $connectBox = ConnectBox::findOrFail($id);
            $connectBox->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/connect');
    }
}
