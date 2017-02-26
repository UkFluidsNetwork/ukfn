<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersFormRequest;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Title;
use App\Group;
use App\Institution;
use App\Tag;
use Auth;
use DB; 

class UsersController extends Controller
{

    /**
     * List all users
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
            ['label' => 'Users', 'path' => '/panel/users']
        ];
        $breadCount = count($bread);

        $users = User::all();
        foreach ($users as $user) {
            $user->created = date("d M H:i", strtotime($user->created_at));
            $user->updated = date("d M H:i", strtotime($user->updated_at));
        }

        return view('panel.users.view', compact('users', 'bread', 'breadCount'));
    }

    /**
     * Edit users
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
            ['label' => 'Users', 'path' => '/panel/users'],
            ['label' => 'Edit', 'path' => '/panel/users/edit'],
        ];
        $breadCount = count($bread);

        $user = User::findOrFail($id);
        $userTags = $user->getTagIds();
        $userInstitutions = $user->getInstitutionIds();
        $institutions = Institution::all();
        $subDisciplines = Tag::getAllDisciplines();
        $applicationAreas = Tag::getAllApplicationAreas();
        $techniques = Tag::getAllTechniques();
        $facilities = Tag::getAllFacilities();
        $titles = Title::lists('shortname', 'id');
        $groups = Group::lists('name', 'id');
        $curDisciplinesCategory = null;
        $curApplicationCategory = null;

        $vars = [
            'user',
            'bread', 
            'breadCount', 
            'titles',
            'groups',
            'subDisciplines', 
            'applicationAreas', 
            'techniques',
            'institutions', 
            'facilities', 
            'curDisciplinesCategory', 
            'curApplicationCategory', 
            'userTags',
            'userInstitutions'
        ];
        
        return view('panel.users.edit', compact($vars));
    }

    /**
     * Update users
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @param EventsFormRequest $request
     * @return void
     */
    public function update($id, UsersFormRequest $request)
    {
        try {
            $user = User::findOrFail($id);
            $input = $request->all();
            $user->fill($input);
            $user->save();
            
            $institutions = $request->institutions ? : [];
            $user->updateInstitutions($institutions);
            $user->updateTags($request->toArray());
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/users');
    }

    /**
     * Add users
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
            ['label' => 'Users', 'path' => '/panel/users'],
            ['label' => 'Add', 'path' => '/panel/users/add'],
        ];
        $breadCount = count($bread);
        $user = new user;
        $userTags = [];
        $userInstitutions = [];
        $institutions = Institution::all();
        $subDisciplines = Tag::getAllDisciplines();
        $applicationAreas = Tag::getAllApplicationAreas();
        $techniques = Tag::getAllTechniques();
        $facilities = Tag::getAllFacilities();
        $titles = Title::lists('name', 'id');
        $groups = Group::lists('name', 'id');
        $curDisciplinesCategory = null;
        $curApplicationCategory = null;

        $vars = [
            'user',
            'bread', 
            'breadCount', 
            'titles',
            'groups',
            'subDisciplines', 
            'applicationAreas', 
            'techniques',
            'institutions', 
            'facilities', 
            'curDisciplinesCategory', 
            'curApplicationCategory', 
            'userTags',
            'userInstitutions'
        ];
        
        return view('panel.users.add', compact($vars));
    }

    /**
     * Create users
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param EventsFormRequest $request
     * @return void
     */
    public function create(UsersFormRequest $request)
    {
        try {
            $user = new User;
            $input = $request->all();
            $user->fill($input);
            $user->save();
            $institutions = $request->institutions ? : [];
            $user->updateInstitutions($institutions);
            $user->updateTags($request->toArray());
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/users');
    }
    
    /**
     * Get all users API => available to Admins and Sig Leaders
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @return json
     */
    public function getUsersJson() 
    {//is admin here
        if (Auth::user()->group_id === 1 || Auth::user()->sigLeader()) {
            
            $key = 0;
        $users = User::all();
        $ukfnUsers = [];
        foreach ($users as $user) {
            $ukfnUsers[$key] = $user;
            $ukfnUsers[$key]->title = $user->title;
            $ukfnUsers[$key]->institutions = $user->institutions;
            $ukfnUsers[$key]->fullname = $user->title->shortname . " " . $user->name . " " . $user->surname;
            $key++;
        }
            
            return json_encode($ukfnUsers, JSON_PRETTY_PRINT);
        } else {
            return json_encode("Error");
        }
    }
    
 
    public function getUserJson($id) 
    {//is admin here
        if (Auth::user()->group_id === 1 || Auth::user()->sigLeader()) {
            
            $user = User::findOrFail($id);
            $user->title;
            $user->institutions;
            $user->fullname = $user->title->shortname . " " . $user->name . " " . $user->surname;
            $user->sigs;
                 
            return json_encode($user, JSON_PRETTY_PRINT);
        } else {
            return json_encode("Error");
        }
    }
}
