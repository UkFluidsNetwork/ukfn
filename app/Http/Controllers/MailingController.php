<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Http\Requests\SendMailRequest;
use App\Subscription;
use App\Message;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\PanelController;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Session;
use App\Jobs\SendEmail;
use App;

class MailingController extends Controller
{

    /**
     * List of supported email addresses
     * @access private
     * @var array
     */
    private $emails = [
        'info' => "info@ukfluids.net",
        'no-reply' => "no-reply@ukfluids.net"
    ];

    /**
     * Subscription Controller for adding new emails
     * 
     * @param SubscriptionRequest $request
     * @return redirect to the viewing page
     * @author Javier Arias <ja573@cam.ac.uk>
     */
    public function subscription(SubscriptionRequest $request)
    {
        $email = $request->input('subscription-email');

        $id = $this->getSubscriptionId($email);
        echo $id;
        if ($id) {
            $subscription = Subscription::findOrFail($id);
            $subscription->deleted = 0;
            $subscription->save();
        } else {
            $subscription = new Subscription;
            $subscription->email = $email;
            $subscription->save();
        }

        $this->addToQueue(env('MAIL_USERNAME'), $email, 'UK Fluids Network Mailing List', ['email' => $email], 'mail.subscribed');

        return Redirect::to(URL::previous() . "#subscription-sign-up-form")->with('subscription_signup_ok', 'Your email has been added to our database.');
    }

    /**
     * Render all Mailing list emails
     * 
     * @return void
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function view()
    {
        if (!PanelController::checkIsAdmin()) {
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
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Subscriptions', 'path' => '/subscriptions']
        ];
        $breadCount = count($bread);

        return view('panel.subscriptions.view', compact('bread', 'breadCount', 'mailingList'));
    }

    /**
     * Render send mail interface
     * @access public
     * @return void
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function send()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Subscriptions', 'path' => '/subscriptions'],
            ['label' => 'Send Mail', 'path' => '/subscriptions/send']
        ];
        $breadCount = count($bread);

        return view('panel.mailing.send', compact('bread', 'breadCount'));
    }

    /**
     * Dispatch email to be sent to the mailing list or other addresses, the message sent is stored.
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param SendMailRequest $request
     * @return void
     */
    public function sendMail(SendMailRequest $request)
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $inputFrom = $request->input('from');
        $subject = $request->input('subject');
        $mailing = (bool) $request->input('mailing');
        $toEmail = explode(';', $request->input('to'));
        $toEmailRaw = $request->input('to');
        $body = $request->input('message');
        $public = (bool) $request->input('public');
        $userID = Auth::user()->id;

        $from = $this->emails[$inputFrom];

        self::addNewMessage($from, $subject, $body, $userID, $public, $mailing, $toEmailRaw);

        switch ($mailing) {
            case true:
                $addresses = Subscription::getEmails();
                $template = "mail.mailinglist";
                break;
            case false:
                $addresses = $toEmail;
                $template = "mail.email";
                $parameters = ['body' => nl2br(e($body))];
                break;
        }

        foreach ($addresses as $address) {
            if (empty($address)) {
                continue;
            }
            if ($mailing) {
                $id = $this->getSubscriptionId($address);
                $querystring = "{" . $address . "}{" . $id . "}";
                $parameters = [
                    'body' => nl2br(e($body)),
                    'address' => $address,
                    'unsubscribe' => "/unsubscribe/" . $querystring
                ];
            }
            $this->addToQueue($from, $address, $subject, $parameters, $template);
        }

        Session::flash('success_message', 'Your e-mail has been sent.');
        return redirect('/sendmail');
    }

    /**
     * Add a message to the mail queue
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param array $parameters the variables to pass onto the template
     * @param string $template
     * @param string $attachment
     */
    public function addToQueue($from, $to, $subject, $parameters, $template = "mail.email", $attachment = null)
    {
        $this->dispatch(new SendEmail($from, $to, $subject, $parameters, $template, $attachment));
    }

    /**
     * Render the unsubscribe page. Checks whether the supplied email and id match.
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param string $querystring {email}{id}
     * @return void
     */
    public function unsubscribe($querystring)
    {
        $explode = explode("}", str_replace('{', '', $querystring), 2);
        $address = $explode[0];
        $id = $explode[1];

        $subscription = Subscription::findOrFail($id);

        if ($subscription->email !== $address) {
            App::abort(404);
        }

        return view('pages.unsubscribe', compact('subscription'));
    }

    /**
     * Mark a subscription as deleted
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function removeSubscription($id)
    {
        try {
            $subscription = Subscription::findOrFail($id);
            $subscription->deleted = 1;
            $subscription->save();
            Session::flash('success_message', 'You have been unsubscribed from the mailing list.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/');
    }

    /**
     * Get the id of a subscription given an email address
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access private
     * @param string $email
     * @return int|null
     */
    private function getSubscriptionId($email)
    {
        return isset(Subscription::getId($email)[0]) ? (int) Subscription::getId($email)[0] : null;
    }

    /**
     * Add new message
     * 
     * @param string $from
     * @param string $subject
     * @param string $body
     * @param intiger $userID
     * @param boolean $public
     * @param boolean $mailing
     * @param string $toEmailRaw
     * @static
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function addNewMessage($from, $subject, $body, $userID, $public, $mailing, $toEmailRaw)
    {
        $m = new Message();
        $m->from = $from;
        $m->subject = $subject;
        $m->body = $body;
        $m->user_id = $userID;
        $m->public = $public;
        $m->mailingList = $mailing;
        $m->to = $toEmailRaw;
        $m->save();
    }
}
