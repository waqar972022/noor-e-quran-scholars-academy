<?php

namespace App\Console\Commands;

use App\Models\UserSubscription;
use App\Notifications\SubscriptionExpired;
use App\Notifications\SubscriptionExpiringSoon;
use Illuminate\Console\Command;

class ProcessSubscriptionExpiry extends Command
{
    protected $signature   = 'subscriptions:process-expiry';
    protected $description = 'Expire overdue subscriptions and send expiry/expiring-soon notifications.';

    public function handle(): int
    {
        $this->expireOverdue();
        $this->notifyExpiringSoon();

        return Command::SUCCESS;
    }

    private function expireOverdue(): void
    {
        // Subscriptions that are still marked active but past their end_date
        $overdue = UserSubscription::with('user')
            ->where('status', 'active')
            ->where('end_date', '<', today())
            ->get();

        foreach ($overdue as $sub) {
            $sub->update(['status' => 'expired']);
            $sub->user->notify(new SubscriptionExpired());
        }

        $this->info("Expired {$overdue->count()} subscription(s).");
    }

    private function notifyExpiringSoon(): void
    {
        // Subscriptions expiring in exactly 3 days — notify once (cron ensures one run/day)
        $expiringSoon = UserSubscription::with('user')
            ->where('status', 'active')
            ->whereDate('end_date', today()->addDays(3))
            ->get();

        foreach ($expiringSoon as $sub) {
            // Guard against duplicate if command is run manually more than once today
            $alreadySent = $sub->user->notifications()
                ->where('data->type', 'subscription_expiring_soon')
                ->where('data->end_date', $sub->end_date->toDateString())
                ->exists();

            if (! $alreadySent) {
                $sub->user->notify(new SubscriptionExpiringSoon($sub));
            }
        }

        $this->info("Notified {$expiringSoon->count()} user(s) of upcoming expiry.");
    }
}
