<?php

namespace App\Jobs;

use App\Mail\StakeholderReminderMail;
use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendStakeholderReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $reminderId) {}

    public function handle(): void
    {
        $reminder = Reminder::with(['project','stakeholder'])->find($this->reminderId);

        if (!$reminder) {
            \Log::warning("Reminder {$this->reminderId} não encontrado.");
            return;
        }

        $stakeholder = $reminder->stakeholder;
        if (!$stakeholder || empty($stakeholder->email)) {
            \Log::warning("Reminder {$reminder->id} sem stakeholder/email. Abortando envio.");
            return;
        }

        Mail::to($stakeholder->email)
            ->send(new StakeholderReminderMail($reminder, $stakeholder));
    }
}
