<?php

namespace App\Http\Controllers;

use App\Sig;
use App\Tag;
use App\User;
use App\Suggestion;
use App\Institution;
use App\Http\Requests\SigsFormRequest;
use Illuminate\Support\Facades\Session;
use SEO;

class SigsController extends Controller
{

    /**
     * Render the SIG overview map
     * 
     * @return void
     */
    public function map($slug = null)
    {
        SEO::setTitle('Special Interest Groups');
        SEO::setDescription('UKFN is pleased to invite proposals for the second round of Special Interest Groups. '
            . 'The call is open to anyone working in fluid mechanics in the UK.');

        $selectedSigId = $slug ? self::getIdBySlug($slug) : 0;
        
        return view('sig.index', compact('selectedSigId'));
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
    }

    public function getSigInstitutionsJson($id)
    {
        $sig = Sig::findOrFail($id);
        // json will get rid of all this stuff, so we need to explicitely load it @todo find a better way
        $sig->institutions;
        $sig->leader;
        foreach ($sig->leader as $key => $leader) {
            $leader = User::findOrFail($sig->leader[$key]->id);
            $sig->leader[$key]->institutions = $leader->institutions;
        }

        return json_encode($sig, JSON_PRETTY_PRINT);
    }

    /**
     * Render a SIG individual page
     * 
     * @access public
     * @param string $slug
     * @return void
     */
    public function sigPage($slug, $page = "home")
    {
        $sig = Sig::findOrfail(self::getIdBySlug($slug));

        SEO::setTitle($sig->name);
        SEO::setDescription($sig->description);

        if ($page === 'map') {
            return $this->map($slug);
        }
        
        // define the selected tab
        $tabs = ['home', 'members'];
        if (!in_array($page, $tabs)) {
            $page = 'home';
        }
        
        // temporary so that tweets are displayed
        $sig->twitterurl = $sig->twitterurl ? : 'UKFluidsNetwork';
        
        // get tweet feeds
        $tweets = [];
        if ($sig->twitterurl) {
            $tweets = PagesController::getTweets($sig->twitterurl, 5);
        }
        // generate navigation buttons
        $allSig = Sig::all();
        $shortname = $sig->shortname;
        $previousSigShortname = $sig->id > 1 ? $allSig[$sig->id - 2]->shortname : $allSig[count($allSig) - 1]->shortname;
        $nextSigShortname = $sig->id < count($allSig) ? $allSig[$sig->id]->shortname : $allSig[0]->shortname;
        $navigation = [
            ['position' => 'left', 'icon' => 'glyphicon-arrow-left', 'path' => "/sig/${previousSigShortname}"],
            ['position' => 'center', 'icon' => 'glyphicon-arrow-up', 'path' => "/sig/${shortname}/map"],
            ['position' => 'right', 'icon' => 'glyphicon-arrow-right', 'path' => "/sig/${nextSigShortname}"]
        ];

        return view('sig.page', compact('sig', 'tweets', 'page', 'navigation'));
    }
    
    /**
     * Find the id of a SIG given its slug
     * 
     * @param string $slug
     * @return int|null
     */
    public static function getIdBySlug($slug)
    {
        $sigStd = Sig::findBySlug($slug)[0];
        
        if (!empty($sigStd)) {
            return $sigStd->id;
        }
        
        return null;
    }
    
    public function results()
    {
        return view('sig.siglist');
    }
}
