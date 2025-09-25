<?php

namespace App\Http\Controllers;

use App\Models\{Project, Reminder, User};
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function create(Project $project)
    {
        return view('reminders.create', ['project' => $project, 'users' => User::orderBy('name')->get()]);
    }
    public function store(Request $r, Project $project)
    {
        $data = $r->validate(['stakeholder_user_id' => 'required|exists:users,id', 'notification_date' => 'required|date']);
        $data['project_id'] = $project->id;
        Reminder::create($data);
        return redirect()->route('projects.show', $project)->with('success', 'Reminder scheduled');
    }
    public function destroy(Project $project, Reminder $reminder)
    {
        $reminder->delete();
        return redirect()->route('projects.show', $project)->with('success', 'Reminder deleted');
    }
}
