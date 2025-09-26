<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Reminder;
use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Jobs\SendReminderEmailJob;

class ReminderController extends Controller
{
    public function create(Project $project)
    {
        $stakeholders = $project->stakeholders()->orderBy('name')->get();
        return view('reminders.create', compact('project', 'stakeholders'));
    }

    public function store(Request $request, Project $project)
{
    $data = $request->validate([
        'stakeholder_id'    => [
            'required',
            Rule::exists('stakeholders', 'id')->where(fn($q) => $q->where('project_id', $project->id)),
        ],
        'notification_date' => ['required', 'date'], // <- obrigatória
    ]);

    // Parse seguro da data (input type="date" = Y-m-d)
    $dateStr  = trim((string) $data['notification_date']);
    $notifyAt = \Carbon\Carbon::createFromFormat('Y-m-d', $dateStr)->startOfDay();

    $reminder = \App\Models\Reminder::create([
        'project_id'        => $project->id,
        'stakeholder_id'    => $data['stakeholder_id'],
        'notification_date' => $notifyAt->toDateString(),
        // 'days_after_deploy' => 0, // (opcional) ignore/retire se quiser
    ]);

    \App\Jobs\SendReminderEmailJob::dispatch($reminder->id)->delay($notifyAt);

    return redirect()
        ->route('projects.show', $project)
        ->with('success', 'Reminder criado e email agendado para a data escolhida.');
}
}
