<?php

namespace App\Jobs;

use App\Models\Reminder;
use App\Mail\ReminderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendReminderEmailJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public int $reminderId) {}

    public function handle(): void
    {
        $reminder = Reminder::with(['project', 'stakeholder'])->find($this->reminderId);
        if (!$reminder) return;

        $to = $reminder->stakeholder->email;
        Mail::to($to)->send(new ReminderMail($reminder));
    }
}
