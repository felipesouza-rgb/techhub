<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Reminder;
use App\Jobs\SendStakeholderReminder;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            Reminder::whereDate('notification_date', now()->toDateString())->get()->each(function ($r) {
                dispatch(new SendStakeholderReminder($r->id));
            });
        })->dailyAt('09:00');
    }
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
