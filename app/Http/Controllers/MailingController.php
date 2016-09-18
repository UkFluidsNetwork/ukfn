<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\SubscriptionRequest;
use App\Http\Requests\SendMailRequest;
use App\Subscription;
use App\Message;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\AdminController;
use Carbon\Carbon;
use Mail;
use Config;
use Auth;
use Illuminate\Support\Facades\Session;

class MailingController extends Controller
{

    /**
     * Subscription Controller for adding new emails
     * 
     * @param SubscriptionRequest $request
     * @return redirect to the viewing page
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function subscription(SubscriptionRequest $request)
    {
        $email = $request->input('subscription-email');
        Subscription::addEmail($email);
        
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
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function view()
    {
        if (!AdminController::checkIsAdmin()) {
            return redirect('/');
        }
        
        $list = Subscription::getAll();
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
        if (!AdminController::checkIsAdmin()) {
            return redirect('/');
        }
   
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
    
    /**
     * Send new mail and store it in messages table
     * 
     * @param SendMailRequest $request
     * @return view
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function sendMail(SendMailRequest $request) 
    {
        if (!AdminController::checkIsAdmin()) {
            return redirect('/');
        }
        
        $from           = $request->input('from');
        $subject        = $request->input('subject');
        $mailing        = ($request->input('mailing') === 'true' ? true : false);
        $toEmail        = explode(';', $request->input('to')); 
        $toEmailRaw     = $request->input('to');
        $body           = $request->input('message');
        $public         = ($request->input('public') === 'true' ? true : false);
        $userID         = Auth::user()->id;
        $mailingList    = Subscription::getAll();
      
        Message::addNew($from.'@ukfluids.net', $subject, $body, $userID, $public, $mailing, $toEmailRaw);
        
        // assign relevant 'from' e-mail address
        if ($from === 'info') {
            Config::set('mail.username', 'info@ukfluids.net');
            Mail::alwaysFrom(null);
            $from = env('MAIL_INFO');
        } elseif ($from === 'no-reply') {
            $from = env('MAIL_USERNAME');
        }
        
        if (!$mailing) {
            foreach($toEmail as $email) {
                Mail::raw($body, function ($message) use ($email, $subject, $from) {
                    $message->from($from, 'UK Fluids Network');
                    $message->to($email);
                    $message->subject($subject);
                });
            }
            
        } else {
            foreach($mailingList as $email) {
                Mail::raw($body, function ($message) use ($email, $subject, $from) {
                    $message->from($from, 'UK Fluids Network');
                    $message->to($email->email);
                    $message->subject($subject);
                });
            }
        }
            
        // set success message
        Session::flash('success_message', 'Your e-mail has been sent.');
        
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
}
