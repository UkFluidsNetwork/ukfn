<?php

namespace App\Http\Controllers;

use Auth;
use Cache;
use App\Sig;
use App\Tag;
use App\User;
use App\File;
use App\Sigbox;
use Carbon\Carbon;
use App\Institution;
use App\Subscription;
use App\Http\Requests\SigsFormRequest;
use App\Http\Requests\SigBoxRequest;
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
     * @return Illuminate\Support\Facades\View
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
     *
     * @return Illuminate\Support\Facades\View
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
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $sig = Sig::findOrFail($id);
        $bread = array_merge(static::$sigPanelCrumbs,
                                [['label' => 'Edit',
                                  'path' => "/panel/sig/edit/${id}"]]);

        if (Auth::user()->isSigEditor()) {
            // only admins have the concept of "the panel" - sig leaders
            // just manage their sig, thus the first crumb is the sig name
            $bread = [['label' => $sig->shortname,
                       'path' => "/panel/sig/${id}"]];
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

        return view('panel.sigs.edit',
                    compact('sig', 'sigTags', 'sigInstitutions',
                            'institutions', 'subDisciplines',
                            'applicationAreas', 'techniques',
                            'facilities', 'curDisciplinesCategory',
                            'curApplicationCategory', 'bread', 'breadCount'));
    }

    /**
     * Update sigs
     *
     * @param int $id
     * @param SigsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function update($id, SigsFormRequest $request)
    {
        $sig = Sig::findOrFail($id);

        try {
            // prevent sig leader to change sig name
            if (Auth::user()->isSigEditorOf($id)) {
                $request['name'] = $sig->name;
                $request['shortname'] = $sig->shortname;
            }

            $input = $request->all();
            $sig->fill($input);
            $sig->mailinglist = isset($input['mailinglist']) ? 1 : 0;
            $sig->active = isset($input['active']) ? 1 : 0;
            $bigImage = $request->file('bigimage');
            $smallImage = $request->file('smallimage');

            if ($bigImage) {
                $name = strtolower($request->shortname) . "_large";
                $sig->bigimage = PagesController::uploadFile($bigImage,
                                                             'sig-pictures',
                                                             $name);
            }
            if ($smallImage) {
                $name = strtolower($request->shortname) . "_small";
                $sig->smallimage = PagesController::uploadFile($smallImage,
                                                               'sig-pictures',
                                                               $name);
            }

            $sig->save();

            $institutions = $request->institutions ?: [];
            $sig->updateInstitutions($institutions);
            $sig->updateTags($request->toArray());
            Cache::forget("sigs-name");
            Cache::forget("sigs-id");
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        if (Auth::user()->isSigEditorOf($id)) {
            return redirect('/panel/sig/edit/' . $id);
        }

        return redirect('/panel/sig');
    }

    /**
     * Add sigs
     *
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
        $bread = array_merge(static::$sigPanelCrumbs,
                             [['label' => 'Add', 'path' => "/panel/sig/add"]]);
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

        return view('panel.sigs.add',
                    compact('sig', 'sigInstitutions', 'sigTags',
                            'institutions', 'subDisciplines',
                            'applicationAreas', 'techniques', 'facilities',
                            'curDisciplinesCategory', 'curApplicationCategory',
                            'bread', 'breadCount'));
    }

    /**
     * Create sigs
     *
     * @param SigsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
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

    /**
     * Get all sigs.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function getAllJson(Request $request)
    {
        $parameters = $request->all();
        $order = isset($parameters['order']) && $parameters['order'] == 'name' ? 'name' : 'id';
        $active = isset($parameters['active']) && $parameters['active'] == '0' ? '0' :  '1';

        // see if request has been cached
        if (Cache::has("sigs-${order}-${active}")) {
           return response()->json(Cache::get("sigs-${order}-${active}"));
        }
        
        $sigs = [];
        $allSigs = Sig::orderBy($order, 'asc')->where('active', $active)->get();

        foreach ($allSigs as $sig) {
            switch ($order) {
                case "name":
                    $sigs[$sig->name] = $sig;
                    $sigs[$sig->name]->institutions = $sig->institutions;
                    break;
                case "id":
                    $sigs[$sig->id] = $sig;
                    $sigs[$sig->id]->institutions = $sig->institutions;
                    break;
            }
        }

        $expiresAt = Carbon::now()->addDay(2);
        Cache::put("sigs-${order}-${active}", $sigs, $expiresAt);
        return response()->json($sigs);
    }

    public function getSigInstitutionsJson($id)
    {
        $sig = Sig::findOrFail($id);
        // json gets rid of all data automatically loaded for the object
        // we need to explictely load it
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
     * @param string $slug
     * @return void
     */
    public function sigPage($slug, $page = "")
    {
        $sig = Sig::findOrfail(self::getIdBySlug($slug));

        SEO::setTitle($sig->name);
        SEO::setDescription($sig->description);

        if ($page === 'map') {
            return $this->map($slug);
        }

        // fixme: temporary so that tweets are displayed
        $sig->twitterurl = $sig->twitterurl ?: 'UKFluidsNetwork';
        $twitter = $sig->twitterurl;

        // generate navigation buttons
        // only navigate active sigs
        $allSig = Sig::orderBy('name')->where('active', 1)->get();
        
        $shortname = $sig->shortname;
        $curSig = 0;
        foreach ($allSig as $k => $s) {
            if ($s->id === $sig->id) {
                $curSig = $k;
                break;
            }
        }

        $previousSigShortname = $curSig > 0
                                ? $allSig[$curSig - 1]->shortname
                                : $allSig[count($allSig) - 1]->shortname;
        $nextSigShortname = $curSig < count($allSig) - 1
                            ? $allSig[$curSig + 1]->shortname
                            : $allSig[0]->shortname;
        $prevSigPath = "/sig/${previousSigShortname}";
        $nextSigPath = "/sig/${nextSigShortname}";
        $mapSigPath = "/sig/${shortname}/map";

        return view('sig.page', compact('sig', 'twitter', 'page',
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
        $sigs   = Sig::findBySlug($slug);
        $sigStd = isset($sigs[0]) ? $sigs[0] : [];

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
     *
     * @param type $id
     * @return Illuminate\Support\Facades\View
     */
    public function members($id)
    {
        if (Auth::user()->isSigEditor()) {
            $bread = [
                ['label' => 'Manage SIG', 'path' => "/panel/sig/edit/${id}"],
                ['label' => 'Add Members',
                 'path' => "/panel/sig/addmembers/${id}"],
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
        return view('panel.sigs.members',
                    compact('id', 'bread', 'breadCount', 'sig'));
    }

    /**
     * API: Get selected sig members
     * Restricted to sig leaders and administrators
     *
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
            $user->fullname = $user->title->shortname . " "
                              . $user->name . " " . $user->surname;
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
                $sig->users()->attach($user->id,
                                      ['main' => $parameters['main']]);
                $actionPerformed = $user->belongsToSig($sig->id);
                break;
            case "update":
                $sig->users()->updateExistingPivot($user->id,
                                              ['main' => $parameters['main']]);
                $actionPerformed = $user->sigStatusId($sig->id)
                                   === $parameters['main'];
                break;
            case "delete":
                $sig->users()->detach($user->id);
                $actionPerformed = !$user->belongsToSig($sig->id);
                break;
        }

        return $actionPerformed ? response()->json("performed: ${action}")
                                : response()->json("could not ${action}", 500);
    }

    /**
     * Google Calendar of SIG meetings
     *
     * @return Illuminate\Support\Facades\View
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

    /**
     * List SIG mailing subscriptions
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function subscriptions($id)
    {
        $sig = Sig::findOrFail($id);
        $mailingList = $sig->subscriptions;

        foreach ($mailingList as $l) {
            $l->created = PagesController::formatDate($l->created_at);
        }

        if (Auth::user()->isSigEditor()) {
            $bread = [
                ['label' => 'Manage SIG', 'path' => "/panel/sig/edit/${id}"],
                ['label' => 'Subscriptions',
                  'path' => "/panel/sig/subscriptions/${id}"],
            ];
        }

        if (Auth::user()->isAdmin()) {
            $bread = array_merge(
                static::$sigPanelCrumbs,
                [
                    ['label' => 'Edit', 'path' => "/panel/sig/edit/${id}"],
                    ['label' => 'Subscriptions',
                     'path' => "/panel/sig/subscriptions/${id}"],
                ]
            );
        }
        $breadCount = count($bread);

        return view('panel.sigs.subscriptions',
                    compact('mailingList', 'bread', 'breadCount'));
    }

    /**
     * Render SIG page design interface
     *
     * @param int $id SIG ID
     * @return Illuminate\Support\Facades\View
     */
    public function listBoxes($id)
    {
        $sig = Sig::findOrFail($id);

        if (Auth::user()->isSigEditor()) {
            $bread = [
                ['label' => 'Manage SIG', 'path' => "/panel/sig/edit/${id}"],
                ['label' => 'Edit Page',
                  'path' => "/panel/sig/box/${id}"],
            ];
        }

        if (Auth::user()->isAdmin()) {
            $bread = array_merge(
                static::$sigPanelCrumbs,
                [
                    ['label' => 'Edit', 'path' => "/panel/sig/edit/${id}"],
                    ['label' => 'Edit Page',
                     'path' => "/panel/sig/box/${id}"],
                ]
            );
        }
        $breadCount = count($bread);

        return view('panel.sigs.viewboxes',
                    compact('sig', 'bread', 'breadCount'));
    }

    /**
     * Render SIG box add interface
     *
     * @param int $id SIG ID
     * @return Illuminate\Support\Facades\View
     */
    public function addBox($id)
    {
        $sig = Sig::findOrFail($id);

        if (Auth::user()->isSigEditor()) {
            $bread = [
                ['label' => 'Manage SIG', 'path' => "/panel/sig/edit/${id}"],
                ['label' => 'Edit Page',
                  'path' => "/panel/sig/box/${id}"],
                ['label' => 'Add Box',
                  'path' => "/panel/sig/box/add/${id}"],
            ];
        }

        if (Auth::user()->isAdmin()) {
            $bread = array_merge(
                static::$sigPanelCrumbs,
                [
                    ['label' => 'Edit', 'path' => "/panel/sig/edit/${id}"],
                    ['label' => 'Edit Page',
                     'path' => "/panel/sig/box/${id}"],
                    ['label' => 'Add Box',
                     'path' => "/panel/sig/box/add/${id}"],
                ]
            );
        }
        $breadCount = count($bread);
        return view('panel.sigs.addbox',
                    compact('sig', 'bread', 'breadCount'));
    }

    /**
     * Render SIG box edit interface
     *
     * @param int $id sig box ID
     * @return Illuminate\Support\Facades\View
     */
    public function editBox($id)
    {
        $sigBox = Sigbox::findOrFail($id);

        if (Auth::user()->isSigEditor()) {
            $bread = [
                ['label' => 'Manage SIG',
                  'path' => "/panel/sig/edit/{$sigBox->sig_id}"],
                ['label' => 'Edit Page',
                  'path' => "/panel/sig/box/{$sigBox->sig_id}"],
                ['label' => 'Edit Box',
                  'path' => "/panel/sig/box/edit/${id}"],
            ];
        }

        if (Auth::user()->isAdmin()) {
            $bread = array_merge(
                static::$sigPanelCrumbs,
                [
                    ['label' => 'Edit',
                     'path' => "/panel/sig/edit/{$sigBox->sig_id}"],
                    ['label' => 'Edit Page',
                     'path' => "/panel/sig/box/{$sigBox->sig_id}"],
                    ['label' => 'Edit Box',
                     'path' => "/panel/sig/box/edit/${id}"],
                ]
            );
        }
        $breadCount = count($bread);
        return view('panel.sigs.editbox',
                    compact('sigBox', 'bread', 'breadCount'));
    }

    /**
     * Create sig box
     *
     * @param SigBoxRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function createBox(SigBoxRequest $request)
    {
        try {
            $sigBox = new Sigbox;
            $input = $request->all();
            $sigBox->fill($input);
            $sigBox->save();

            Session::flash('success_message', 'Added succesfully. '
                . 'Boxes are disabled by default. Click on enable '
                . 'to have them displayed on the SIG page.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/sig/box/' . $sigBox->sig_id);
    }

    /**
     * Update sig box
     *
     * @param int $id box id
     * @param SigBoxRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function updateBox($id, SigBoxRequest $request)
    {
        try {
            $sigBox = Sigbox::findOrFail($id);
            $input = $request->all();
            $sigBox->fill($input);
            $sigBox->save();
            Session::flash('success_message', 'Updated succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/sig/box/' . $sigBox->sig_id);
    }

    /**
     * Change the order of a box
     *
     * @param string $direction up/down
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function moveBox($direction, $id)
    {
        try {
            $sigBox = Sigbox::findOrFail($id);
            if ($direction === "up") {
                $sigBox->order--;
            } else {
                $sigBox->order++;
            }
            $sigBox->save();
            Session::flash('success_message', 'Moved succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/sig/box/' . $sigBox->sig_id);
    }


    /**
     * Enable/disable a sig box
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function toggleBoxStatus($id)
    {
        try {
            $sigBox = Sigbox::findOrFail($id);
            if ($sigBox->status() === "Enabled") {
                $sigBox->active = 0;
            } else {
                $sigBox->active = 1;
            }
            $sigBox->save();
            Session::flash('success_message', $sigBox->status()
                                              . ' succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/sig/box/' . $sigBox->sig_id);
    }

    /**
     * Delete sig boxes
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function deleteBox($id)
    {
        try {
            $sigBox = Sigbox::findOrFail($id);
            $sigBox->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/sig/box/' . $sigBox->sig_id);
    }
    /**
     * List sig files
     *
     * @return Illuminate\Support\Facades\View
     */
    public function listFiles($id)
    {
        $sig = Sig::findOrFail($id);
        $bread = [
          ['label' => 'Manage SIG', 'path' => "/panel/sig/edit/${id}"],
          ['label' => 'Files',
            'path' => "/panel/sig/files/${id}"],
         ];

        $breadCount = count($bread);

        $thisServer = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

        $files = $sig->files->sortByDesc("created_at");
        foreach ($files as $file) {
            $file->created = PagesController::formatDate($file->created_at);
            $file->updated = PagesController::formatDate($file->updated_at);
            $file->full_path = url($file->path . "/" . $file->name);
        }

        return view('panel.sigs.files',
                    compact('bread', 'breadCount', 'files', 'sig'));
    }
    /**
     * Add new sig file view
     *
     * @return Illuminate\Support\Facades\View
     */
    public function addFile($id)
    {
        $sig = Sig::findOrFail($id);
        $bread = [
          ['label' => 'Manage SIG', 'path' => "/panel/sig/edit/${id}"],
          ['label' => 'Add File',
            'path' => "/panel/sig/files/add/${id}"],
         ];

        $file = new File();
        $breadCount = count($bread);

        return view('panel.sigs.addfile',
                    compact('bread', 'breadCount', 'file', 'sig'));
    }
}

