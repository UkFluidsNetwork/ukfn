<?php

namespace App\Jobs;

use Mail;
use Config;
use App\Jobs\Job;
use App\Sentmessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Job implements ShouldQueue
{

    use InteractsWithQueue,
        SerializesModels;

    /**
     * The address to send the message from
     *
     * @var string
     */
    private $from = "no-reply@fluids.ac.uk";

    /**
     * The name associated with the address to send the message from
     *
     * @var string
     */
    private $fromName = "UK Fluids Network";

    /**
     * The address to send the message to
     *
     * @var string
     */
    private $to;

    /**
     * The subject of the message
     *
     * @var string
     */
    private $subject;

    /**
     * The variables to pass on to the template
     *
     * @var array [[variableName] => [value]]
     */
    private $parameters;

    /**
     * The blade template used for compiling the body of the message
     *
     * @var string
     */
    private $template;

    /**
     * The the file to be attached in the message. The file must have been previously uploaded
     *
     * @var array
     */
    private $attachment;

    public function __construct($from, $to, $subject, $parameters, $template, $attachment = null)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->parameters = $parameters;
        $this->template = $template;
        $this->attachment = $attachment;
    }

    /**
     * We want to create a sentmessage record to keep track ot the actual emails sent
     *
     * @return void
     */
    public function handle()
    {
        if ($this->tooManyAttempts()) {
            $this->notifyWebmaster();
        }

        $this->overrideDefaultUser($this->from);

        $messageSent = false;

        do {
            $messageSent = $this->send();
        } while (!$messageSent);

        if ($messageSent) {
            $this->sentMessage = $this->createSentMessage();
            $this->sentMessage->sent = date("Y-m-d H:i:s");
            $this->sentMessage->save();
        }
    }

    /**
     * Send mail
     *
     * @return boolean
     */
    private function send()
    {
        return Mail::send($this->template, $this->parameters,
                          function ($message) {
                $message->from($this->from, $this->fromName);
                $message->to($this->to);
                $message->subject($this->subject);
                if ($this->attachment) {
                    $message->attach($this->attachment['path'],
                                     ['as' => $this->attachment['name']]);
                }
            });
    }

    /**
     * Check whether this job has been tried too many times (set to 5).
     *
     * @return boolean
     */
    private function tooManyAttempts()
    {
        return $this->attempts() > 5 ? true : false;
    }

    /**
     * Send an email to webmaster notifying the number of failed attempts.
     * We obviously do not want to put this message in the queue,
     * hence the use of a simple mail() function
     *
     * @return void
     */
    private function notifyWebmaster()
    {
        mail(
            env('WEBMASTER'),
            "UKFN - Failed to process email",
            "Could not send email to " . $this->to . ". Attempted "
            . $this->attempts() . "times."
        );
    }

    /**
     * Set the mail user to be the selected from address
     *
     */
    private function overrideDefaultUser()
    {
        Config::set('mail.username', $this->from);
        Mail::alwaysFrom(null);
    }

    /**
     * Adds a new sentmessage
     *
     * @return Sentmessage
     */
    private function createSentMessage()
    {
        $sentMessage = new Sentmessage();
        $sentMessage->from = $this->from;
        $sentMessage->to = $this->to;
        $sentMessage->subject = $this->subject;
        $sentMessage->template = $this->template;
        $sentMessage->parameters = serialize($this->parameters);
        $sentMessage->attachment = $this->attachment;
        $sentMessage->save();

        return $sentMessage;
    }
}

