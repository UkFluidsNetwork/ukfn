<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Title;
use App\Tag;
use App\Institution;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use SEO;

class AuthController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        SEO::setTitle('Login | Register');
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,
                [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $userCreated = User::create([
                'title_id' => $data['title_id'],
                'group_id' => 3, // member
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
        ]);

        if ($userCreated) {
            Session::flash('success_message', 'Thank you for registering.');
            return true;
        } else {
            return false;
        }
    }

    /**
     * Show the application registration form.
     *
     * @return void
     */
    public function showRegistrationForm()
    {
        SEO::setTitle('Register');

        $titles           = Title::all();
        $institutions     = Institution::all();
        $subDisciplines   = Tag::getAllDisciplines();
        $applicationAreas = Tag::getAllApplicationAreas();
        $techniques       = Tag::getAllTechniques();
        $facilities       = Tag::getAllFacilities();

        $curDisciplinesCategory = null;
        $curApplicationCategory = null;

        $lastInstitution = 0;
        if (!empty($institutions)) {
            foreach ($institutions as $institution) {
                if ($institution->id > $lastInstitution) {
                    $lastInstitution = $institution->id;
                }
            }
        }

        $lastTag = 0;
        if (!empty($subDisciplines)) {
            foreach ($subDisciplines as $discipline) {
                if ($discipline->id > $lastTag) {
                    $lastTag = $discipline->id;
                }
            }
        }

        if (!empty($applicationAreas)) {
            foreach ($applicationAreas as $application) {
                if ($application->id > $lastTag) {
                    $lastTag = $application->id;
                }
            }
        }

        if (!empty($techniques)) {
            foreach ($techniques as $technique) {
                if ($technique->id > $lastTag) {
                    $lastTag = $technique->id;
                }
            }
        }

        if (!empty($facilities)) {
            foreach ($facilities as $facilitie) {
                if ($facilitie->id > $lastTag) {
                    $lastTag = $facilitie->id;
                }
            }
        }

        // otherwise the first one to be used is the lates one, we want the following, next available, id
        $lastInstitution++;
        $lastTag++;

        return view('auth.register',
            compact('titles', 'subDisciplines', 'applicationAreas', 'techniques', 'institutions', 'facilities',
                'curDisciplinesCategory', 'curApplicationCategory', 'lastInstitution', 'lastTag'));
    }
}