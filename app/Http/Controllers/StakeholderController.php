<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StakeholderController extends Controller
{
    public function index(Project $project)
    {
        $stakeholders = $project->stakeholders()->orderBy('name')->paginate(10);
        return view('stakeholders.index', compact('project', 'stakeholders'));
    }

    public function create(Project $project)
    {
        return view('stakeholders.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('stakeholders')->where(fn ($q) => $q->where('project_id', $project->id))
            ],
            'role'  => ['nullable', 'string', 'max:255'],
        ]);

        $project->stakeholders()->create($data);

        return redirect()
            ->route('projects.stakeholders.index', $project)
            ->with('success', 'Stakeholder cadastrado com sucesso.');
    }

    public function edit(Project $project, Stakeholder $stakeholder)
    {
        $this->authorizeProject($project, $stakeholder);
        return view('stakeholders.edit', compact('project', 'stakeholder'));
    }

    public function update(Request $request, Project $project, Stakeholder $stakeholder)
    {
        $this->authorizeProject($project, $stakeholder);

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('stakeholders')->ignore($stakeholder->id)->where(fn ($q) => $q->where('project_id', $project->id))
            ],
            'role'  => ['nullable', 'string', 'max:255'],
        ]);

        $stakeholder->update($data);

        return redirect()
            ->route('projects.stakeholders.index', $project)
            ->with('success', 'Stakeholder atualizado com sucesso.');
    }

    public function destroy(Project $project, Stakeholder $stakeholder)
    {
        $this->authorizeProject($project, $stakeholder);
        $stakeholder->delete();

        return redirect()
            ->route('projects.stakeholders.index', $project)
            ->with('success', 'Stakeholder removido.');
    }

    private function authorizeProject(Project $project, Stakeholder $stakeholder): void
    {
        if ($stakeholder->project_id !== $project->id) {
            abort(404);
        }
    }
}
