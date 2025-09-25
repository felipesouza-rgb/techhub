<?php

namespace App\Http\Controllers;

use App\Models\{Project, User};
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function manage(Project $project)
    {
        return view('projects.users', ['project' => $project->load('users'), 'allUsers' => User::orderBy('name')->get()]);
    }
    public function attach(Project $project, User $user)
    {
        $project->users()->syncWithoutDetaching([$user->id]);
        return back()->with('success', 'User attached');
    }
    public function detach(Project $project, User $user)
    {
        $project->users()->detach($user->id);
        return back()->with('success', 'User detached');
    }
}
