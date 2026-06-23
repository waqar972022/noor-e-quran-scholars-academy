<?php

use App\Console\Commands\ProcessSubscriptionExpiry;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Scheduled Commands
|--------------------------------------------------------------------------
|
| SERVER CRON ENTRY (add once on the server):
|   * * * * * cd /var/www/noor-e-quran && php artisan schedule:run >> /dev/null 2>&1
|
| This single cron line runs the Laravel scheduler every minute,
| which then dispatches the commands below at their configured intervals.
|
*/

Schedule::command(ProcessSubscriptionExpiry::class)
    ->dailyAt('02:00')       // Runs at 02:00 PKT every day
    ->withoutOverlapping()   // Skip if previous run is still going
    ->appendOutputTo(storage_path('logs/subscription-expiry.log'));
