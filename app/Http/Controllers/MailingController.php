<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\SubscriptionRequest;
use App\Http\Requests\SendMailRequest;
use App\Mailing;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\AdminController;
use Carbon\Carbon;
use Mail;
use Config;
class MailingController extends Controller
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
        Mailing::addEmail($email);
        
        // Config::set('mail.username', 'no-reply@ukfluids.net');
        // Mail::alwaysFrom(null);
        
        Mail::send('mail.subscribed', ['email' => $email], function ($message) use ($email) {
           $message->from(env('MAIL_USERNAME'), 'UKFN Mailing List');
           $message->to($email);
           $message->subject('UKFN Mailing List');

        });
           
        return Redirect::to(URL::previous() . "#subscription-sign-up-form")->with('subscription_signup_ok', 'Your email has been added to our database.');
    }
    
    /**
     * Render all Mailing list emails
     * 
     * @return object   HTML View
     * @author Robert Barczyk <robert@barczyk.net>
     * @access public
     */
    public function view()
    {
        if(!AdminController::checkIsAdmin()) {
          return redirect('/');
        }
        
        $list = Mailing::getAll();
        $mailingList = [];
        $index = 0;
        
        foreach ($list as $result) {
            $mailingList[$index]['email'] = $result->email;
            $mailingList[$index]['created_at'] = Carbon::parse($result->created_at)->format('l jS F, H:i');
            $index++;
        }
            
        // Bread crumbs array
        $bread = [
            ['label' => 'Home', 'path'=>'/'],
            ['label' => 'Admin','path' => '/admin'],
            ['label' => 'Subscriptions','path' => '/subscriptions']
        ];
        
        $breadCount  = count($bread);
        
        return view('admin.subscriptions.view', compact('bread', 'breadCount', 'mailingList'));
    }
    
    public function send()
    {
        
        //$subject = $request->input('subject');
        //$messsage = $request->input('message');
        // Bread crumbs array
        $bread = [
            ['label' => 'Home', 'path'=>'/'],
            ['label' => 'Admin','path' => '/admin'],
            ['label' => 'Subscriptions','path' => '/subscriptions'],
            ['label' => 'Send Mail','path' => '/subscriptions/send']
        ];
        
        $breadCount  = count($bread);
        
        return view('admin.mailing.send', compact('bread', 'breadCount'));
    }
    
    public function sendMail(SendMailRequest $request) 
    {
        var_dump($_POST);
    }
}
