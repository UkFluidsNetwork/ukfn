<?php

namespace App\Http\Controllers;

use Auth;
use App\Sig;
use App\Tag;
use App\User;
use App\Institution;
use App\Http\Requests\SigsFormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use SEO;

class SigsController extends Controller
{

    private static $sigPanelCrumbs = [
        ['label' => 'Panel', 'path' => '/panel'],
        ['label' => 'SIG', 'path' => '/panel/sig']
    ];

    /**
     * Render the SIG overview page; the map is not rendered on mobiles.
     *
     * @param string $slug Used to preselect a SIG, if provided
     * @return void
     */
    public function map($slug = null)
    {
        $selectedSigId = $slug ? self::getIdBySlug($slug) : 0;
        $agent = new Agent();
        $isMobile = $agent->isMobile();

        if ($isMobile) {
            $title = "SIG";
        } else {
            $title = "Special Interest Groups";
        }

        SEO::setTitle($title);
        SEO::setDescription("Special Interest Groups (SIGs) are open to anyone"
            . " working in fluid mechanics in the UK. There are 41 SIGs"
            . " spanning 64 universities.");

        return view('sig.index', compact('selectedSigId', 'isMobile'));
    }

    /**
     * List all sigs
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return void
     */
    public function view()
    {
        $bread = static::$sigPanelCrumbs;
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
     * @author Robert Barczyk <robert@barczyk.net>
     * @access public
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        $sig = Sig::findOrFail($id);

        if (Auth::user()->isSigLeader()) {
            $bread = [['label' => $sig->shortname, 'path' => "/panel/sig/${id}"]];
        }

        if (Auth::user()->isAdmin()) {
            $bread = array_merge(static::$sigPanelCrumbs, [['label' => 'Edit', 'path' => "/panel/sig/edit/${id}"]]);
        }

        $breadCount = count($bread);
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
     * @author Robert Barczyk <rb783@cam.ac.uk>
     * @access public
     * @param int $id
     * @param EventsFormRequest $request
     * @return void
     */
    public function update($id, SigsFormRequest $request)
    {
        $sig = Sig::findOrFail($id);

        try {
            // prevent sig leader to change sig name
            if (Auth::user()->isLeaderOfSig($id)) {
                $request['name'] = $sig->name;
            }

            $input = $request->all();
            $sig->fill($input);
            $bigImage = $request->file('bigimage');
            $smallImage = $request->file('smallimage');

            if ($bigImage) {
                $sig->bigimage = PagesController::uploadFile($bigImage, 'sig-pictures', strtolower($request->shortname) . "_large_");
            }
            if ($smallImage) {
                $sig->smallimage = PagesController::uploadFile($bigImage, 'sig-pictures', strtolower($request->shortname) . "_small_");
            }

            $sig->save();

            $institutions = $request->institutions ?: [];
            $sig->updateInstitutions($institutions);
            $sig->updateTags($request->toArray());
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        if (Auth::user()->isLeaderOfSig($id)) {
            return redirect('/panel/sig/edit/' . $id);
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
        $bread = array_merge(static::$sigPanelCrumbs, [['label' => 'Add', 'path' => "/panel/sig/add"]]);
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
        $allSigs = Sig::orderBy('name', 'asc')->get();

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

    public function getSigUSers($id)
    {
        $users = Sig::findOrFail($id);
        $users->users();
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
        $sig->twitterurl = $sig->twitterurl ?: 'UKFluidsNetwork';

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
        $prevSigPath = "/sig/${previousSigShortname}";
        $nextSigPath = "/sig/${nextSigShortname}";
        $mapSigPath = "/sig/${shortname}/map";

        return view('sig.page', compact('sig', 'tweets', 'page',
            'prevSigPath', 'nextSigPath', 'mapSigPath'));
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

    /**
     * Add any ukfn member to selected SIG
     * Restricted to admin and SIG leaders
     * 
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     * @param type $id
     * @return type
     */
    public function members($id)
    {
        if (Auth::user()->isSigLeader()) {
            $bread = [
                ['label' => 'Manage SIG', 'path' => "/panel/sig/edit/${id}"],
                ['label' => 'Add Members', 'path' => "/panel/sig/addmembers/${id}"],
            ];
        }

        if (Auth::user()->isAdmin()) {
            $bread = array_merge(
                static::$sigPanelCrumbs, 
                [
                    ['label' => 'Edit', 'path' => "/panel/sig/edit/${id}"],
                    ['label' => 'Members', 'path' => "/panel/sig/members/${id}"],
                ]
            );
        }

        $sig = Sig::findOrFail($id);
        $breadCount = count($bread);
        return view('panel.sigs.members', compact('id', 'bread', 'breadCount', 'sig'));
    }

    /**
     * API: Get selected sig members
     * Restricted to sig leaders and administrators
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @param int $id Sig id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSigMembersJson($id)
    {
        $users = [];
        $sig = Sig::findOrFail($id);

        foreach ($sig->users as $user) {
            $user->title;
            $user->institutions;
            $user->fullname = $user->title->shortname . " " . $user->name . " " . $user->surname;
            $user->pivot;
            $users[] = $user;
        }

        return response()->json($users);
    }

    /**
     * Attach a user to a sig
     * 
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function administerMember($action, $id, Request $request)
    {
        $actionsAllowed = ["add", "update", "delete"];
        $parameters = $request->all();

        if (empty($parameters)) {
            return response()->json('Invalid data', 500);
        }

        if (!in_array($action, $actionsAllowed)) {
            return response()->json('Invalid action', 500);
        }

        if ($action !== "delete" && !Sig::isStatusValid($parameters['main'])) {
            return response()->json('Invalid status', 500);
        }

        $sig = Sig::findOrFail($id);
        $user = User::findOrFail($parameters['user_id']);
        
        switch ($action) {
            case "add":
                $sig->users()->attach($user->id, ['main' => $parameters['main']]);
                $actionPerformed = $user->belongsToSig($sig->id);
                break;
            case "update":
                $sig->users()->updateExistingPivot($user->id, ['main' => $parameters['main']]);
                $actionPerformed = $user->sigStatusId($sig->id) === $parameters['main'];
                break;
            case "delete":
                $sig->users()->detach($user->id);
                $actionPerformed = !$user->belongsToSig($sig->id);
                break;
        }
        
        return $actionPerformed ? response()->json("performed: ${action}") : response()->json("could not ${action}", 500);
    }

    /**
     * Google Calendar of SIG meetings
     *
     * @author Robert Barczyk <rb783@cam.ac.uk>
     * @return void
     */
    public static function calendar()
    {
        SEO::setTitle('Calendar of SIG meetings');
        SEO::setDescription('Calendar of all the meetings organised by the Special Interest Groups (SIG) that participate in the UK FLuids Network.');

        $agent = new Agent();
        $isMobile = $agent->isMobile();

        if ($isMobile) {
            $backBtn = "SIG Overview";
        } else {
            $backBtn = "SIG Map";
        }


        return view('sig.calendar', compact('bread', 'backBtn'));
    }
}
