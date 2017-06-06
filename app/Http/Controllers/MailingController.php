<?php

namespace app\Http\Controllers;

use App;
use Auth;
use Storage;
use App\Message;
use Carbon\Carbon;
use App\Subscription;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\SendMailRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PagesController;
use App\Http\Requests\SubscriptionRequest;

class MailingController extends Controller
{

    /**
     * List of supported email addresses
     *
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
     */
    public function subscription(SubscriptionRequest $request)
    {
        $email = $request->input('subscription-email');
        $user_id = isset(Auth::user()->id) ? Auth::user()->id : null;

        $this->subscribe($email, $user_id);

        $this->addToQueue(env('MAIL_USERNAME'),
                          $email,
                          'UK Fluids Network Mailing List',
                          ['email' => $email],
                          'mail.subscribed');

        return Redirect::to(URL::previous() . "#subscription-sign-up-form")
                          ->with('subscription_signup_ok',
                                 'Your email has been added to our database.');
    }

    /**
     * Register a new address in the subscriptions list
     *
     * @param string $email
     * @param int $user_id
     */
    public function subscribe($email, $user_id = null)
    {
        $id = $this->getSubscriptionId($email);

        if ($id) {
            Subscription::withTrashed()->where('id', $id)->restore();
            $subscription = Subscription::findOrFail($id);
            $subscription->user_id = $user_id;
            $subscription->save();
        } else {
            $subscription = new Subscription;
            $subscription->email = $email;
            $subscription->user_id = $user_id;
            $subscription->save();
        }
    }

    /**
     * Render mailing list view
     *
     * @return void
     */
    public function view()
    {
        $mailingList = Subscription::All();

        foreach ($mailingList as $r) {
            $r->created = PagesController::formatDate($r->created_at);
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Subscriptions', 'path' => '/panel/subscriptions']
        ];
        $breadCount = count($bread);

        return view('panel.subscriptions.view',
                    compact('bread', 'breadCount', 'mailingList'));
    }

    /**
     * Render send mail interface
     *
     * @return void
     */
    public function send()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Subscriptions', 'path' => '/panel/subscriptions'],
            ['label' => 'Send Mail', 'path' => '/panel/subscriptions/send']
        ];
        $breadCount = count($bread);

        return view('panel.mailing.send', compact('bread', 'breadCount'));
    }

    /**
     * Dispatch email to be sent to the mailing list or other addresses,
     * the message sent is stored.
     *
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
        $mailing = (int) $request->input('mailinglist');
        $toEmail = explode(';', $request->input('to'));
        $toEmailRaw = $request->input('to');
        $body = $request->input('message');
        $public = (int) $request->input('public');
        $userID = Auth::user()->id;
        $from = $this->emails[$inputFrom];
        $attachment = null; //$request->file('attachment');

        if ($attachment) {
            $attOriginalName = $attachment->getClientOriginalName();
            Storage::disk("attachments")->put($attOriginalName, $attachment);
            $storagePath = Storage::disk('attachments')->getDriver()->getAdapter()->getPathPrefix();
            $attRealPath = $storagePath . $attOriginalName;
            $attachment = ['path' => $attRealPath, 'name' => $attOriginalName];
        } else {
            $attOriginalName = null;
        }

        self::addNewMessage($from, $subject, $body, $userID, $public, $mailing, $toEmailRaw, $attOriginalName);

        switch ($mailing) {
            case 1:
                $addresses = Subscription::getEmails();
                $template = "mail.mailinglist";
                break;
            case 0:
                $addresses = $toEmail;
                $template = "mail.email";
                $parameters = ['body' => nl2br($body)];
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
                    'body' => nl2br($body),
                    'address' => $address,
                    'unsubscribe' => "/unsubscribe/" . $querystring
                ];
            }
            $this->addToQueue($from, $address, $subject, $parameters, $template, $attachment);
        }

        Session::flash('success_message', 'Your e-mail has been sent.');
        return redirect('/panel/sendmail');
    }

    /**
     * Add a message to the mail queue
     *
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param array $parameters the variables to pass onto the template
     * @param string $template
     * @param string $attachment
     */
    public function addToQueue($from, $to, $subject, $parameters,
                               $template = "mail.email", $attachment = null)
    {
        $this->dispatch(new SendEmail(
                $from, $to, $subject, $parameters, $template, $attachment));
    }

    /**
     * Render the unsubscribe page.
     * Checks whether the supplied email and id match.
     *
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
     *
     * @param int $id
     * @return void
     */
    public function removeSubscription($id)
    {
        try {
            $this->cancelSubscription($id);
            Session::flash('success_message',
                'You have been unsubscribed from the mailing list.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/');
    }

    /**
     * Admin version of removeSubscription()
     *
     * @param int $id
     * @return void
     */
    public function deleteSubscription($id)
    {
        try {
            $this->cancelSubscription($id);
            Session::flash('success_message', 'Subscription removed.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/subscriptions');
    }

    /**
     * Delete a subscription by id or email address
     *
     * @param int $id
     * @param string $email
     * @return boolean
     */
    public function cancelSubscription($id = null, $email = null,
                                       $user_id = null)
    {
        if (!$id && !$email && !$user_id) {
            return false;
        }

        $subscription_id = $id
                           ? $id
                           : ($email
                              ? $this->getSubscriptionId($email)
                              : $this->getSubscriptionIdByUser($user_id));
        $subscription = Subscription::findOrFail($subscription_id);

        return $subscription->delete();
    }

    /**
     * Set a thankful flash message and redirect to home
     *
     * @return void
     */
    public function keepSubscription()
    {
        Session::flash('success_message',
            'Thank you for keeping your subscription to the mailing list.');
        return redirect('/');
    }

    /**
     * Get the id of a subscription given an email address
     *
     * @param string $email
     * @return int|null
     */
    private function getSubscriptionId($email)
    {
        return isset(Subscription::getIdByEmail($email)[0])
               ? (int) Subscription::getIdByEmail($email)[0]
               : null;
    }

    /**
     * Get the id of a subscription given a user id
     *
     * @param int $user_id
     * @return int|null
     */
    private function getSubscriptionIdByUser($user_id)
    {
        return isset(Subscription::getIdByUser($user_id)[0])
               ? (int) Subscription::getIdByUser($user_id)[0]
               : null;
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
     */
    public static function addNewMessage($from, $subject, $body, $userID,
                                         $public, $mailing, $toEmailRaw,
                                         $attachment)
    {
        $m = new Message();
        $m->from = $from;
        $m->subject = $subject;
        $m->body = $body;
        $m->user_id = $userID;
        $m->public = $public;
        $m->mailingList = $mailing;
        $m->to = $toEmailRaw;
        $m->attachment = $attachment;
        $m->save();
    }
}
