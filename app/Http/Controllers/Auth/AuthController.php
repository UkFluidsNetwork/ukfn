<?php

namespace App\Http\Controllers\Auth;

use Auth as Authentication;
use App\User;
use App\Title;
use App\Tag;
use App\Institution;
use App\Http\Controllers\MailingController;
use Validator;
use Illuminate\Support\Facades\Session;
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
    protected $redirectTo = '/myaccount';

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
        return Validator::make($data, [
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
        $newUser = User::create([
                'title_id' => $data['title_id'] ? : null,
                'group_id' => 3, // member
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'orcidid' => isset($data['orcidid']) ? $data['orcidid'] : null,
                'url' => isset($data['url']) ? $data['url'] : null
        ]);

        if (!$newUser) {
            return false;
        }
        
        $newUser->updateInstitutions($data['institutions']);
        $newUser->updateTags($data);

        //subscription
        if ($data['subscription']) {
            $mailing = new MailingController;
            $mailing->subscribe($data['email'], $newUser->id);
        }

        Session::flash('message', 'Thank you for registering.');
        Session::flash('alert-class', 'alert-success');
        return Authentication::loginUsingId($newUser->getAuthIdentifier());
    }

    /**
     * Show the application registration form.
     *
     * @return void
     */
    public function showRegistrationForm()
    {
        SEO::setTitle('Register');

        $titles = Title::all();
        $institutions = Institution::all();
        $subDisciplines = Tag::getAllDisciplines();
        $applicationAreas = Tag::getAllApplicationAreas();
        $techniques = Tag::getAllTechniques();
        $facilities = Tag::getAllFacilities();
        $curDisciplinesCategory = null;
        $curApplicationCategory = null;

        return view('auth.register', compact('titles', 'subDisciplines', 'applicationAreas', 'techniques', 'institutions', 'facilities', 'curDisciplinesCategory', 'curApplicationCategory'));
    }
}
