<?php

namespace App\Http\Controllers;

use App\Models\{Project, Company, User, Backlog, Changelog};
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', ['projects' => Project::with('company')->latest()->paginate(10)]);
    }
    public function create()
    {
        return view('projects.create', ['companies' => Company::all()]);
    }
    public function store(Request $r)
    {
        $data = $r->validate(['name' => 'required|max:255', 'description' => 'nullable', 'stakeholder_name' => 'nullable|max:255', 'company_id' => 'required|exists:companies,id']);
        $project = Project::create($data);
        return redirect()->route('projects.show', $project)->with('success', 'Project created');
    }
    public function show(Project $project)
    {
        $project->load(['company', 'users', 'backlogs.assignee', 'changelogs.user']);
        return view('projects.show', compact('project'));
    }
    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project, 'companies' => Company::all()]);
    }
    public function update(Request $r, Project $project)
    {
        $data = $r->validate(['name' => 'required|max:255', 'description' => 'nullable', 'stakeholder_name' => 'nullable|max:255', 'company_id' => 'required|exists:companies,id']);
        $project->update($data);
        return redirect()->route('projects.show', $project)->with('success', 'Project updated');
    }
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted');
    }
}
