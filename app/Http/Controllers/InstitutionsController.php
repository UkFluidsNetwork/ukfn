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
     *
     * @return Illuminate\Support\Facades\View
     */
    public function view()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Institutions', 'path' => '/panel/institutions']
        ];
        $breadCount = count($bread);

        $institutions = Institution::all();
        foreach ($institutions as $institution) {
            $institution->created = PagesController::formatDate(
                                        $institution->created_at);
            $institution->updated = PagesController::formatDate(
                                        $institution->updated_at);
        }

        return view('panel.institutions.view',
                    compact('institutions', 'bread', 'breadCount'));
    }

    /**
     * Edit an institution
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Institutions', 'path' => '/panel/institutions'],
            ['label' => 'Edit', 'path' => '/panel/institutions/edit'],
        ];
        $breadCount = count($bread);

        $institution = Institution::findOrFail($id);
        $institutiontypes = Institutiontype::lists('name', 'id');

        return view('panel.institutions.edit',
                    compact('institution', 'bread', 'breadCount',
                            'institutiontypes'));
    }

    /**
     * Update an institution
     *
     * @param int $id
     * @param InstitutionsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Institutions', 'path' => '/panel/institutions'],
            ['label' => 'Add', 'path' => '/panel/institutions/add'],
        ];
        $breadCount = count($bread);
        $institutiontypes = Institutiontype::lists('name', 'id');

        return view('panel.institutions.add',
                    compact('bread', 'breadCount', 'institutiontypes'));
    }

    /**
     * Create an institution
     *
     * @param InstitutionsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
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

    /**
     * Get all institutions in JSON format
     */
    public function getAllJson()
    {
        return Institution::all()->toJson();
    }

    /**
     * Return array of institution_id => name
     *
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

