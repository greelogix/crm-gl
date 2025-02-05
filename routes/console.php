<?php

use App\Console\Commands\CheckNegotiationStatus;
use App\Mail\ReminderMail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command(CheckNegotiationStatus::class)->everyMinute();


// Schedule::call(function(){
//     Schedule::command(CheckNegotiationStatus::class)->everyMinute();
// })->everyMinute();
