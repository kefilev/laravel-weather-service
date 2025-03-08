<?php

use App\Jobs\SendWeatherReportEmailsJob;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {

//     Log::debug('inspire command');
//     /** @var ClosureCommand $this */
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

Schedule::command('app:send-weather-report-emails')->everyMinute();

// Schedule::job(new SendWeatherReportEmailsJob)->everyMinute();
