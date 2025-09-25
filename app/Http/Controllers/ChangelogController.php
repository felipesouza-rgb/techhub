<?php

namespace App\Http\Controllers;

use App\Models\{Project, Changelog, Backlog, User};
use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    public function create(Project $project)
    {
        return view('changelogs.create', ['project' => $project, 'users' => User::orderBy('name')->get(), 'backlogs' => Backlog::where('project_id', $project->id)->orderBy('created_at', 'desc')->get()]);
    }
    public function store(Request $r, Project $project)
    {
        $data = $r->validate(['deploy_date' => 'nullable|date', 'user_id' => 'nullable|exists:users,id', 'version' => 'required|max:50', 'status' => 'required|in:deploy_pending,deployed,rollback', 'backlog_id' => 'nullable|exists:backlogs,id']);
        $data['project_id'] = $project->id;
        Changelog::create($data);
        return redirect()->route('projects.show', $project)->with('success', 'Changelog entry created');
    }
    public function edit(Project $project, Changelog $changelog)
    {
        return view('changelogs.edit', ['project' => $project, 'changelog' => $changelog, 'users' => User::orderBy('name')->get(), 'backlogs' => Backlog::where('project_id', $project->id)->get()]);
    }
    public function update(Request $r, Project $project, Changelog $changelog)
    {
        $data = $r->validate(['deploy_date' => 'nullable|date', 'user_id' => 'nullable|exists:users,id', 'version' => 'required|max:50', 'status' => 'required|in:deploy_pending,deployed,rollback', 'backlog_id' => 'nullable|exists:backlogs,id']);
        $changelog->update($data);
        return redirect()->route('projects.show', $project)->with('success', 'Changelog updated');
    }
    public function destroy(Project $project, Changelog $changelog)
    {
        $changelog->delete();
        return redirect()->route('projects.show', $project)->with('success', 'Changelog deleted');
    }
}
