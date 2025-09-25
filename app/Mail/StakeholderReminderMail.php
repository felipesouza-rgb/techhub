<?php

namespace App\Mail;

use App\Models\{Project, Reminder};
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StakeholderReminderMail extends Mailable
{
    use Queueable, SerializesModels;
    public Project $project;
    public Reminder $reminder;
    public function __construct(Project $project, Reminder $reminder)
    {
        $this->project = $project;
        $this->reminder = $reminder;
    }
    public function build()
    {
        return $this->subject('Reminder: Deploy follow-up — ' . $this->project->name)->view('emails.reminder');
    }
}
