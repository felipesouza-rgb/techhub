<?php

namespace App\Http\Controllers;

use App\Models\{Project, Backlog, User};
use Illuminate\Http\Request;

class BacklogController extends Controller
{
    public function create(Project $project)
    {
        return view('backlogs.create', ['project' => $project, 'users' => User::orderBy('name')->get()]);
    }
    public function store(Request $r, Project $project)
    {
        $data = $r->validate(['task_name' => 'required|max:255', 'description' => 'nullable', 'type' => 'required|in:feature,bugfix,new screen', 'status' => 'required|in:pending,in_progress,done', 'assigned_to' => 'nullable|exists:users,id', 'priority' => 'required|integer|min:1|max:5']);
        $data['project_id'] = $project->id;
        Backlog::create($data);
        return redirect()->route('projects.show', $project)->with('success', 'Task created');
    }
    public function edit(Project $project, Backlog $backlog)
    {
        return view('backlogs.edit', ['project' => $project, 'backlog' => $backlog, 'users' => User::orderBy('name')->get()]);
    }
    public function update(Request $r, Project $project, Backlog $backlog)
    {
        $data = $r->validate(['task_name' => 'required|max:255', 'description' => 'nullable', 'type' => 'required|in:feature,bugfix,new screen', 'status' => 'required|in:pending,in_progress,done', 'assigned_to' => 'nullable|exists:users,id', 'priority' => 'required|integer|min:1|max:5']);
        $backlog->update($data);
        return redirect()->route('projects.show', $project)->with('success', 'Task updated');
    }
    public function destroy(Project $project, Backlog $backlog)
    {
        $backlog->delete();
        return redirect()->route('projects.show', $project)->with('success', 'Task deleted');
    }
}
