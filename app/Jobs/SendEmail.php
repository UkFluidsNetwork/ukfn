<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Config;
use Mail;

class SendEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue,
        SerializesModels;

    /**
     * The address to send the message from
     *
     * @access private
     * @var string
     */
    private $from;
    
    /**
     * The name associated with the address to send the message from
     *
     * @access private
     * @var string
     */
    private $fromName = "UK Fluids Network";
    
    /**
     * The address to send the message to
     *
     * @access private
     * @var string
     */
    private $to;
    
    /**
     * The subject of the message
     *
     * @access private
     * @var string
     */
    private $subject;
    
    /**
     * The variables to pass on to the template
     *
     * @access private
     * @var array [[variableName] => [value]]
     */
    private $parameters;
    
    /**
     * The blade template used for compiling the body of the message
     *
     * @access private
     * @var string
     */
    private $template;
    
    /**
     * The object of the file to be attached in the message. The file must have been previously uploaded
     *
     * @access private
     * @var object
     */
    private $attachment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from, $to, $subject, $parameters, $template, $attachment)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->parameters = $parameters;
        $this->template = $template;
        $this->attachment = $attachment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->tooManyAttempts()) {
            $this->notifyWebmaster();
        }
        
        $this->overrideDefaultUser($this->from);
        
        Mail::send($this->template, $this->parameters, function ($message) {
            $message->from($this->from, $this->fromName);
            $message->to($this->to);
            $message->subject($this->subject);
            if ($this->attachment) {
                $message->attach(
                    $this->attachment->getRealPath(),
                    ['as' => $this->attachment->getClientOriginalName()]
                );
            }
        });
    }
    
    /**
     * Check whether this job has been tried too many times (set to 5).
     *
     * @access private
     * @return boolean
     */
    private function tooManyAttempts()
    {
        return $this->attempts() > 5 ? true : false;
    }
    
    /**
     * Send an email to webmaster notifying the number of failed attempts.
     * We obviously do not want to put this message in the queue, hence using a simple mail() function
     *
     * @access private
     */
    private function notifyWebmaster()
    {
        mail(
            env('WEBMASTER'),
            "UKFN - Failed to process email",
            "Could not send email to " . $this->to . ". Attempted " . $this->attempts() . "times."
        );
    }
    
    /**
     * Set the mail user to be the selected from address
     *
     * @access private
     */
    private function overrideDefaultUser()
    {
        Config::set('mail.username', $this->from);
        Mail::alwaysFrom(null);
    }
}
