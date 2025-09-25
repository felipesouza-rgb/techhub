<?php

namespace App\Jobs;

use App\Models\Reminder;
use App\Mail\StakeholderReminderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendStakeholderReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $reminderId;
    public function __construct(int $reminderId)
    {
        $this->reminderId = $reminderId;
    }
    public function handle(): void
    {
        $reminder = Reminder::with(['project', 'stakeholder'])->find($this->reminderId);
        if (!$reminder) {
            return;
        }
        Mail::to(optional($reminder->stakeholder)->email)->send(new StakeholderReminderMail($reminder->project, $reminder));
    }
}
