<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SubscriptionRequest;
use App\Subscription;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class SubscriptionsController extends Controller
{
  /**
   * Subscription Controller for adding new emails
   * 
   * @param SubscriptionRequest $request
   * @return redirect to the viewing page
   * @author Robert Barczyk <rb783@cam.ac.uk>
   */
  public function subscription(SubscriptionRequest $request)
  {
    $email    = $request->input('subscription-email');
    Subscription::addEmail($email);
    return Redirect::to(URL::previous(). "#subscription-sign-up-form")->with('subscription_signup_ok', 'Your email has been added to our database.');
  }
}
