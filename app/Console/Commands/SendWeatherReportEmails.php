<?php

namespace App\Console\Commands;

use App\Mail\WeatherReportMail;
use App\Models\EmailSubscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWeatherReportEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-weather-report-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send-weather-report-emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscribers = EmailSubscriber::all();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new WeatherReportMail($subscriber));
        }

        $this->info('Emails sent successfully!');
    }
}
