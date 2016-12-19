<?php

namespace App\Http\Controllers;

use App\Sig;
use App\Tag;
use App\Suggestion;
use App\Institution;
use App\Http\Requests\SigsFormRequest;
use Illuminate\Support\Facades\Session;
use SEO;

class SigsController extends Controller
{

    public function index()
    {
        SEO::setTitle('Special Interest Groups');
        SEO::setDescription('UKFN is pleased to invite proposals for the second round of Special Interest Groups. '
            . 'The call is open to anyone working in fluid mechanics in the UK.');

        $sigs = Sig::all();
        $allSuggestions = Suggestion::getAllSuggestions();
        $totalSuggestions = count($allSuggestions);

        return view('sig.index', compact('sigs', 'allSuggestions', 'totalSuggestions'));
    }

    /**
     * Render the SIG overview map
     * 
     * @return void
     */
    public function map()
    {
        SEO::setTitle('Special Interest Groups');
        SEO::setDescription('UKFN is pleased to invite proposals for the second round of Special Interest Groups. '
            . 'The call is open to anyone working in fluid mechanics in the UK.');

        return view('sig.map');
    }

    /**
     * List all sigs
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
                ['label' => 'SIG', 'path' => '/panel/sig']
        ];
        $breadCount = count($bread);

        $sigs = Sig::all();
        foreach ($sigs as $sig) {
            $sig->created = date("d M H:i", strtotime($sig->created_at));
            $sig->updated = date("d M H:i", strtotime($sig->updated_at));
        }

        return view('panel.sigs.view', compact('sigs', 'bread', 'breadCount'));
    }

    /**
     * Edit sigs
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'SIG', 'path' => '/panel/sig'],
                ['label' => 'Edit', 'path' => '/panel/sig/edit'],
        ];
        $breadCount = count($bread);

        $sig = Sig::findOrFail($id);
        $sigTags = $sig->getTagIds();
        $sigInstitutions = $sig->getInstitutionIds();
        $institutions = Institution::all();
        $subDisciplines = Tag::getAllDisciplines();
        $applicationAreas = Tag::getAllApplicationAreas();
        $techniques = Tag::getAllTechniques();
        $facilities = Tag::getAllFacilities();
        $curDisciplinesCategory = null;
        $curApplicationCategory = null;

        return view('panel.sigs.edit', compact('sig', 'sigTags', 'sigInstitutions', 'institutions', 'subDisciplines', 'applicationAreas', 'techniques', 'facilities', 'curDisciplinesCategory', 'curApplicationCategory', 'bread', 'breadCount'));
    }

    /**
     * Update sigs
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @param EventsFormRequest $request
     * @return void
     */
    public function update($id, SigsFormRequest $request)
    {
        try {
            $sig = Sig::findOrFail($id);
            $input = $request->all();
            $sig->fill($input);
            $sig->save();

            $institutions = $request->institutions ?: [];
            $sig->updateInstitutions($institutions);
            $sig->updateTags($request->toArray());
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/sig');
    }

    /**
     * Add sigs
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function add()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'SIG', 'path' => '/panel/sig'],
                ['label' => 'Add', 'path' => '/panel/sig/add'],
        ];
        $breadCount = count($bread);

        $sig = new Sig;
        $sigTags = [];
        $sigInstitutions = [];
        $institutions = Institution::all();
        $subDisciplines = Tag::getAllDisciplines();
        $applicationAreas = Tag::getAllApplicationAreas();
        $techniques = Tag::getAllTechniques();
        $facilities = Tag::getAllFacilities();
        $curDisciplinesCategory = null;
        $curApplicationCategory = null;

        return view('panel.sigs.add', compact('sig', 'sigInstitutions', 'sigTags', 'institutions', 'subDisciplines', 'applicationAreas', 'techniques', 'facilities', 'curDisciplinesCategory', 'curApplicationCategory', 'bread', 'breadCount'));
    }

    /**
     * Create sigs
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param EventsFormRequest $request
     * @return void
     */
    public function create(SigsFormRequest $request)
    {
        try {
            $sig = new Sig;
            $input = $request->all();
            $sig->fill($input);
            $sig->save();

            $institutions = $request->institutions ?: [];
            $sig->updateInstitutions($institutions);
            $sig->updateTags($request->toArray());
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/sig');
    }

    /**
     * Delete sigs
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $sig = Sig::findOrFail($id);
            $sig->deleted = 1;
            $sig->save();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/sig');
    }

    public function getAllJson()
    {
        $sigs = [];
        $key = 0;
        $allSigs = Sig::all();

        foreach ($allSigs as $sig) {
            $sigs[$key] = $sig;
            $sigs[$key]->institutions = $sig->institutions;
            $key++;
        }
        return json_encode($sigs, JSON_PRETTY_PRINT);
//         foreach ()
//             $sig->instutions = $sig->institutions();
    }

    public function getSigInstitutionsJson($id)
    {
        $sig = Sig::findOrFail($id);
        $sig->institutions;
        return json_encode($sig, JSON_PRETTY_PRINT);
    }
}
