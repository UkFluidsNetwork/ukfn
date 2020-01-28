<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersFormRequest;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Ecmember;
use App\Title;
use App\Group;
use App\Institution;
use App\Tag;
use App\File;
use DB;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            Cache::flush();
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
            $user->disciplines;

            $user->sigs;
            $users[] = $user;
        }

        return response()->json($users);
    }

    /*
     * Get all users with reduced information in JSON format
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUsersPublicJson(Request $request)
    {
        $parameters = $request->all();
        $search = isset($parameters['search'])
                       && $parameters['search'] !== "[]"
            ? json_decode($parameters['search'])
            : null;

        if (is_array($search)) {
            sort($search);
        }

        $tags = [];
        $sigs = [];
        $inst = [];
        $key  = "";
        if ($search !== null) {
            foreach ($search as $val) {
                $key .= $val;
                $tagPos = strpos($val, "tag") !== false;
                $sigPos = strpos($val, "sig") !== false;
                $insPos = strpos($val, "inst") !== false;
                if ($tagPos) {
                    $tags[] = str_replace("tag", "", $val);
                } elseif ($sigPos) {
                    $sigs[] = str_replace("sig", "", $val);
                } elseif ($insPos) {
                    $inst[] = str_replace("inst", "", $val);
                }
            }
        }

        // see if request has been cached
        if (Cache::has('directory'.$key)) {
            return response()->json(Cache::get('directory'.$key));
        }

        $users = [];
        $allUsers = DB::table('users')
            ->select('users.id', 'users.name', 'users.surname', 'users.url')
            ->leftJoin('sig_users', 'users.id', '=', 'sig_users.user_id')
            ->leftJoin('user_tags', 'users.id', '=', 'user_tags.user_id')
            ->leftJoin('institution_users', 'users.id',
                        '=', 'institution_users.user_id')
            ->leftJoin('sigs', 'sig_users.sig_id', '=', 'sigs.id')
            ->leftJoin('tags', 'user_tags.tag_id', '=', 'tags.id')
            ->leftJoin('institutions', 'institution_users.institution_id',
                        '=', 'institutions.id')
            ->where("researcher", 1)
            ->where("gdpr", 1)
            ->when(!empty($tags), function($query) use ($tags) {
                return $query->where(function($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere("tag_id", $tag);
                    }
                });
            })
            ->when(!empty($sigs), function($query) use ($sigs) {
                return $query->where(function($query) use ($sigs) {
                    foreach ($sigs as $sig) {
                        $query->orWhere("sig_id", $sig);
                    }
                });
            })
            ->when(!empty($inst), function($query) use ($inst) {
                return $query->where(function($query) use ($inst) {
                    $query->whereIn("institution_id", $inst);
                });
            })
            ->orderBy("surname")
            ->distinct()
            ->get();

        foreach ($allUsers as $userStd) {
            $user = $userStd;
            $user->institution_ids = DB::table('institution_users')
                ->select('institution_id')
                ->where("user_id", $userStd->id)->get();
            $user->tag_ids = DB::table('user_tags')
                ->select('tag_id')
                ->where("user_id", $userStd->id)->get();
            $user->sig_ids = DB::table('sig_users')
                ->select('sig_id', 'main')
                ->where("user_id", $userStd->id)->get();
            $users[] = $user;
        }

        $expiresAt = Carbon::now()->addDay(1);
        Cache::put('directory'.$key, $users, $expiresAt);
        return response()->json($users);
    }

    /*
     * Get all users with reduced information in JSON format
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUserinstitutionsPublicJson(Request $request)
    {
        $parameters = $request->all();
        $search = isset($parameters['search'])
                       && $parameters['search'] !== "[]"
            ? json_decode($parameters['search'])
            : null;

        if (is_array($search)) {
            sort($search);
        }

        $tags = [];
        $sigs = [];
        $inst = [];
        $key  = "";
        if ($search !== null) {
            foreach ($search as $val) {
                $key .= $val;
                $tagPos = strpos($val, "tag") !== false;
                $sigPos = strpos($val, "sig") !== false;
                $insPos = strpos($val, "inst") !== false;
                if ($tagPos) {
                    $tags[] = str_replace("tag", "", $val);
                } elseif ($sigPos) {
                    $sigs[] = str_replace("sig", "", $val);
                } elseif ($insPos) {
                    $inst[] = str_replace("inst", "", $val);
                }
            }
        }

        // see if request has been cached
        if (Cache::has('directory-institutions'.$key)) {
            return response()->json(Cache::get('directory-institutions'.$key));
        }

        $institutions = [];
        $allInstitutions = DB::table('institutions')
            ->select(DB::raw('institutions.id, count(distinct(users.id)) as user_count'))
            ->leftJoin('institution_users', 'institutions.id',
                        '=', 'institution_users.institution_id')
            ->leftJoin('users', 'institution_users.user_id',
                        '=', 'users.id')
            ->leftJoin('sig_users', 'users.id', '=', 'sig_users.user_id')
            ->leftJoin('user_tags', 'users.id', '=', 'user_tags.user_id')
            ->leftJoin('sigs', 'sig_users.sig_id', '=', 'sigs.id')
            ->leftJoin('tags', 'user_tags.tag_id', '=', 'tags.id')
            ->where("researcher", 1)
            ->where("gdpr", 1)
            ->when(!empty($tags), function($query) use ($tags) {
                return $query->where(function($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere("tag_id", $tag);
                    }
                });
            })
            ->when(!empty($sigs), function($query) use ($sigs) {
                return $query->where(function($query) use ($sigs) {
                    foreach ($sigs as $sig) {
                        $query->orWhere("sig_id", $sig);
                    }
                });
            })
            ->groupBy('institutions.id')
            ->get();

        foreach ($allInstitutions as $institutionStd) {
            $institution = Institution::find($institutionStd->id);
            $institutions[$institutionStd->id] = $institution;
            $institutions[$institutionStd->id]['user_count'] =
                $institutionStd->user_count;
        }

        $expiresAt = Carbon::now()->addDay(1);
        Cache::put('directory-institutions'.$key, $institutions, $expiresAt);
        return response()->json($institutions);
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

    /**
     * Accept GDPR t&c
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function acceptGdpr($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->gdpr = 1;
            $user->save();

            Session::flash('success_message',"Thank you. Your confirmation has been saved.");
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/');
    }

    /**
     * Attach a user to the executive committee
     *
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function administerEcMember($action, Request $request)
    {
        $actionsAllowed = ["add", "update", "delete"];
        $parameters = $request->all();

        if (empty($parameters)) {
            return response()->json('Invalid data', 500);
        }

        if (!in_array($action, $actionsAllowed)) {
            return response()->json('Invalid action', 500);
        }

        $user = User::findOrFail($parameters['user_id']);

        switch ($action) {
            case "add":
                $membership = new Ecmember;
                $membership->user_id = $user->id;
                $actionPerformed = $membership->save();
                break;
            case "update":
                if (!$user->ecmembership) {
                    return response()->json('Invalid data', 500);
                }
                $file = File::findOrFail($parameters['file_id']);
                $user->ecmembership->file_id = $parameters['file_id'];
                $user->ecmembership->role = $parameters['role'];
                $actionPerformed = $user->ecmembership->update();
                break;
            case "delete":
                if (!$user->ecmembership) {
                    return response()->json('Invalid data', 500);
                }
                $actionPerformed = $user->ecmembership->delete();
                break;
        }

        return $actionPerformed ? response()->json("performed: ${action}")
                                : response()->json("could not ${action}", 500);
    }

    /*
     * Get all EC users in JSON format
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEcJson()
    {
        $members = [];
        $allMembers = Ecmember::all();

        foreach ($allMembers as $member) {
            $user = $member->user;
            $file = $member->file;
            $member->title = $user->title->shortname;
            $member->name = $user->name;
            $member->surname = $user->surname;
            $member->fullname = $member->title . " " . $member->name
                . " " . $member->surname;
            $member->photo = $file ? url($file->path . "/" . $file->name) : "";
            $member->homepage = $user->url;
            $member->institutions = "";
            foreach ($member->user->institutions as $index => $institution) {
                $member->institutions .= $institution->name;
                if ($index !== count($member->institutions)-1) {
                    $member->institutions .= ", ";
                }
            }
            unset($member->user);
            unset($member->file);
            $members[] = $member;
        }

        return response()->json($members);
    }

      /*
       * Get all images under /ec
       *
       * @return \Symfony\Component\HttpFoundation\Response
       */
      public function ecphotosJson()
      {
        $photos = DB::table('files')
                ->select('id', 'name')
                ->where("path", "/pictures/ec")->get();

          return response()->json($photos);
      }

    /**
     * Add any ukfn member to the EC
     *
     * @return Illuminate\Support\Facades\View
     */
    public function ecmembers()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Users', 'path' => '/panel/users'],
            ['label' => 'Executive Committee', 'path' => '/panel/users/ec']
        ];
        $breadCount = count($bread);

        return view('panel.users.ec', compact('bread', 'breadCount'));
    }
}

