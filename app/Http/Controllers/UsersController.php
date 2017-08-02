<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersFormRequest;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Title;
use App\Group;
use App\Institution;
use App\Tag;

class UsersController extends Controller
{

    /**
     * List all users
     *
     * @return Illuminate\Support\Facades\View
     */
    public function view()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Users', 'path' => '/panel/users']
        ];
        $breadCount = count($bread);

        $users = User::all();
        foreach ($users as $user) {
            $user->created = PagesController::formatDate($user->created_at);
            $user->updated = PagesController::formatDate($user->updated_at);
        }

        return view('panel.users.view',
                     compact('users', 'bread', 'breadCount'));
    }

    /**
     * Edit users
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
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

        return view('panel.users.edit',
                    compact('user', 'bread', 'breadCount', 'titles', 'groups',
                            'subDisciplines', 'applicationAreas', 'techniques',
                            'institutions', 'facilities',
                            'curDisciplinesCategory', 'curApplicationCategory',                             'userTags', 'userInstitutions'));
    }

    /**
     * Update users
     *
     * @param int $id
     * @param EventsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
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

        return view('panel.users.add',
                    compact('user', 'bread', 'breadCount', 'titles', 'groups',
                            'subDisciplines', 'applicationAreas', 'techniques',
                            'institutions', 'facilities',
                            'curDisciplinesCategory', 'curApplicationCategory',
                            'userTags', 'userInstitutions'));
    }

    /**
     * Create users
     *
     * @param EventsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     * Delete a user
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/users');
    }

    /**
     * Full list of users to export to CSV
     *
     * @return void
     * @return Illuminate\Support\Facades\View
     */
    public function export()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Users', 'path' => '/panel/users'],
            ['label' => 'Export', 'path' => '/panel/users/export'],
        ];
        $breadCount = count($bread);

        $users = User::all();

        return view('panel.users.export',
                     compact('users', 'bread', 'breadCount'));
    }

    /*
     * Get all users in JSON format
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUsersJson()
    {
        $users = [];
        $allUsers = User::all();

        foreach ($allUsers as $user) {
            $user->title;
            $user->institutions;
            $user->fullname = $user->title->shortname . " "
                              . $user->name . " " . $user->surname;
            $user->sigs;
            $users[] = $user;
        }

        return response()->json($users);
    }

    /**
     * Get a specic user in JSON, givent it's $id
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUserJson($id)
    {
        $user = User::findOrFail($id);
        $user->title;
        $user->institutions;
        $user->fullname = $user->title->shortname . " "
                          . $user->name . " " . $user->surname;
        $user->sigs;

        return response()->json($user);
    }
}

