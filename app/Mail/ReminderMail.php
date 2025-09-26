<?php

namespace App\Mail;

use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reminder $reminder) {}

    public function build()
    {
        $p = $this->reminder->project;
        $s = $this->reminder->stakeholder;

        return $this->subject("Schedule Reminder — {$p->name}")
            ->view('emails.reminder')
            ->with([
                'project'   => $p,
                'stakeholder' => $s,
                'reminder'  => $this->reminder,
            ]);
    }
}
