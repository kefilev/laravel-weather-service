<?php

namespace App\Console\Commands;

use App\Mail\WeatherReportMail;
use App\Models\EmailSubscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        Log::debug('SendWeatherReportEmails command triggered');

        foreach ($subscribers as $subscriber) {
            $address = config('services.weatherstack.address');
            $api_key = config('services.weatherstack.api_key');
            $url = "$address/current?access_key=$api_key&query=$subscriber->location";

            try {
                //Get weather data from API
                $response = Http::get($url);

                if ($response->ok()) {
                    $data = $response->json();
                    //Send the email
                    Mail::to($subscriber->email)->send(new WeatherReportMail($subscriber, $response->json()));
                    $this->info('Emails sent successfully!');
                } else {
                    Log::error('SendWeatherReportEmails weatherstack API problem: ' . $response->status() . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('SendWeatherReportEmails weatherstack API problem: ' . $e->getMessage());
                //TODO try again or put in queue
            }
        } 
    }
}
