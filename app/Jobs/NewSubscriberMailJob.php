<?php

namespace App\Jobs;

use App\Mail\NewSubscriberMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Mail;
use Log;

class NewSubscriberMailJob implements ShouldQueue
{
    use Queueable;

    private $subscriber;

    /**
     * Create a new job instance.
     */
    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::debug('NewSubscriberMailJob triggered');
        Mail::to($this->subscriber->email)->send(new NewSubscriberMail($this->subscriber));
    }
}
