<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstitutionsFormRequest;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Institution;
use App\Institutiontype;

class InstitutionsController extends Controller
{

    /**
     * List all institutions
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return void
     */
    public function view()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Institutions', 'path' => '/panel/institutions']
        ];
        $breadCount = count($bread);

        $institutions = Institution::all();
        foreach ($institutions as $institution) {
            $institution->created = date("d M H:i", strtotime($institution->created_at));
            $institution->updated = date("d M H:i", strtotime($institution->updated_at));
        }

        return view('panel.institutions.view', compact('institutions', 'bread', 'breadCount'));
    }

    /**
     * Edit an institution
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Institutions', 'path' => '/panel/institutions'],
            ['label' => 'Edit', 'path' => '/panel/institutions/edit'],
        ];
        $breadCount = count($bread);

        $institution = Institution::findOrFail($id);
        $institutiontypes = Institutiontype::lists('name', 'id');

        return view('panel.institutions.edit', compact('institution', 'bread', 'breadCount', 'institutiontypes'));
    }

    /**
     * Update an institution
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @param InstitutionsFormRequest $request
     * @return void
     */
    public function update($id, InstitutionsFormRequest $request)
    {
        try {
            $institution = Institution::findOrFail($id);
            $input = $request->all();
            $institution->fill($input);
            $institution->save();
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/institutions');
    }

    /**
     * Add an institution
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function add()
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Institutions', 'path' => '/panel/institutions'],
            ['label' => 'Add', 'path' => '/panel/institutions/add'],
        ];
        $breadCount = count($bread);
        $institutiontypes = Institutiontype::lists('name', 'id');

        return view('panel.institutions.add', compact('bread', 'breadCount', 'institutiontypes'));
    }

    /**
     * Create an institution
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param InstitutionsFormRequest $request
     * @return void
     */
    public function create(InstitutionsFormRequest $request)
    {
        try {
            $institution = new Institution;
            $input = $request->all();
            $institution->fill($input);
            $institution->save();
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/institutions');
    }

    /**
     * Delete an institution
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $institution = Institution::findOrFail($id);
            $institution->deleted = 1;
            $institution->save();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/institutions');
    }

    public function getAllJson()
    {
        return Institution::all()->toJson();
    }
    
    /**
     * Return array of institution_id => name
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @return array
     */
    public static function getSelect()
    {
        $institutions = Institution::all();
        $foramated = [];        
        foreach ($institutions as $institution) {
            $foramated[$institution->id] = $institution->name;
        }
        return $foramated;
    }
}
