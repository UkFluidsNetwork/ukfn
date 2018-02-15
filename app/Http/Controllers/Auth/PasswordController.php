<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use SEO;

class PasswordController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after password reset
     *
     * @var string
     */
    protected $redirectTo = '/myaccount';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        SEO::setTitle('Password Reset');
        $this->middleware('guest');
    }
}
