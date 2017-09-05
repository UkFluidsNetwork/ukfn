<?php

namespace App\Http\Controllers;

use SEO;
use App\Srv;
use App\Institution;
use App\Http\Requests\SrvsFormRequest;
use Illuminate\Support\Facades\Session;

class SrvsController extends Controller
{

    private static $srvPanelCrumbs = [
        ['label' => 'Panel', 'path' => '/panel'],
        ['label' => 'SRV', 'path' => '/panel/srv']
    ];

    public function index()
    {
        SEO::setTitle('Short Research Visits');
        SEO::setDescription('UKFN is pleased to invite proposals for SRVs. The call is open to anyone working in fluid mechanics in the UK.');

        $srvs = Srv::all();
        return view('srv.index', compact('srvs'));
    }

    /**
     * Render SRV panel interface
     *
     * @return Illuminate\Support\Facades\View
     */
    public function view()
    {
        $bread = static::$srvPanelCrumbs;
        $breadCount = count($bread);

        $srvs = Srv::all();

        return view('panel.srvs.view', compact('srvs', 'bread', 'breadCount'));
    }

    /**
     * Render SRV edit interface
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $srv = Srv::findOrFail($id);
        $institutions = Institution::lists('name', 'id');
        $bread = array_merge(static::$srvPanelCrumbs,
                                [['label' => 'Edit',
                                  'path' => "/panel/srv/edit/${id}"]]);

        $breadCount = count($bread);

        return view('panel.srvs.edit',
                    compact('srv', 'institutions', 'bread', 'breadCount'));
    }

    /**
     * Update srvs
     *
     * @param int $id
     * @param SrvsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function update($id, SrvsFormRequest $request)
    {
        $srv = Srv::findOrFail($id);
        try {
            $input = $request->all();
            $srv->fill($input);
            $srv->save();
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/srv');
    }


    /**
     * Add srvs
     *
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
        $bread = array_merge(static::$srvPanelCrumbs,
                             [['label' => 'Add', 'path' => "/panel/srv/add"]]);
        $breadCount = count($bread);

        $srv = new Srv;
        $institutions = Institution::lists('name', 'id');
        return view('panel.srvs.add',
                    compact('srv', 'institutions', 'bread', 'breadCount'));
;
    }

    /**
     * Create srvs
     *
     * @param SrvsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function create(SrvsFormRequest $request)
    {
        try {
            $srv = new Srv;
            $input = $request->all();
            $srv->fill($input);
            $srv->save();
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/srv');
    }

    /**
     * Delete srvs
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function delete($id)
    {
        try {
            $srv = Srv::findOrFail($id);
            $srv->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/srv');
    }
}

