<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\SubscriptionRequest;
use App\Subscription;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\AdminController;

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
        $email = $request->input('subscription-email');
        Subscription::addEmail($email);
        return Redirect::to(URL::previous() . "#subscription-sign-up-form")->with('subscription_signup_ok', 'Your email has been added to our database.');
    }
    
    public function viewAll()
    {
        
        if(!AdminController::checkIsAdmin()) {
          return redirect('/');
        }
            
        $bread = [
            ['label' => 'Home', 'path'=>'/'],
            ['label' => 'Admin','path' => '/admin'],
            ['label' => 'View All Subscriptions','path' => '/admin/mailingall']
        ];
        
        $breadCount  = count($bread);
        
        return view('admin.subscriptions.viewall', compact('bread', 'breadCount'));
    }
}
