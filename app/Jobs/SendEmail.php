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

    protected $from;
    protected $to;
    protected $subject;
    protected $parameters;
    protected $template;
    protected $attachment;

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
        Config::set('mail.username', $this->from);
        Mail::alwaysFrom(null);

        Mail::send($this->template, $this->parameters, function ($message) {
            $message->from($this->from, 'UK Fluids Network');
            $message->to($this->to);
            $message->subject($this->subject);
            if ($this->attachment) {
                $message->attach($this->attachment->getRealPath(), ['as' => $this->attachment->getClientOriginalName()]);
            }
        });
    }
}
