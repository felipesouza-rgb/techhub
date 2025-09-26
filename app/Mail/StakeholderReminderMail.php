<?php

namespace App\Mail;

use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StakeholderReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Reminder $reminder,
        public $stakeholder // App\Models\User ou Stakeholder
    ) {}

    public function build()
    {
        return $this->subject('Lembrete de Deploy - '.$this->reminder->project?->name)
            ->markdown('emails.reminders.stakeholder', [
                'reminder'    => $this->reminder,
                'project'     => $this->reminder->project,
                'stakeholder' => $this->stakeholder,
            ]);
    }
}
