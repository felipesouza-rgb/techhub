<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 space-y-6">
        @if(session('success'))
        <div class="p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>@endif
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">{{ $project->name }}</h1>
            <a class="px-4 py-2 rounded bg-gray-100" href="{{ route('projects.users.manage', $project) }}">Manage
                Users</a>
        </div>
        <div class="grid md:grid-cols-3 gap-4">
            <div class="p-4 bg-white shadow rounded">
                <div class="text-gray-500">Company</div>
                <div class="text-lg">{{ $project->company->name }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded">
                <div class="text-gray-500">Stakeholder</div>
                <div class="text-lg">{{ $project->stakeholder_name ?? '—' }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded">
                <div class="text-gray-500">Members</div>
                <div class="text-lg">{{ $project->users->count() }}</div>
            </div>
        </div>


        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-semibold">Backlog</h2><a class="text-indigo-600"
                        href="{{ route('projects.backlogs.create', $project) }}">New Task</a>
                </div>
                <div class="bg-white shadow rounded divide-y">
                    @forelse($project->backlogs as $b)
                        <div class="p-3 flex items-center justify-between">
                            <div>
                                <div class="font-medium">{{ $b->task_name }} <span
                                        class="text-xs text-gray-500">#{{ $b->id }}</span></div>
                                <div class="text-sm text-gray-600">Type: {{ $b->type }} • Status: {{ $b->status }} •
                                    Priority: {{ $b->priority }}</div>
                                <div class="text-sm text-gray-600">Assignee: {{ optional($b->assignee)->name ?? '—' }}</div>
                            </div>
                            <div class="flex gap-3">
                                <a class="text-blue-600" href="{{ route('projects.backlogs.edit', [$project, $b]) }}">Edit</a>
                                <form method="POST" action="{{ route('projects.backlogs.destroy', [$project, $b]) }}"
                                    onsubmit="return confirm('Delete task?')">@csrf @method('DELETE')<button
                                        class="text-red-600">Delete</button></form>
                            </div>
                        </div>
                    @empty
                        <div class="p-3 text-gray-500">No tasks yet.</div>
                    @endforelse
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-semibold">Changelog</h2><a class="text-indigo-600"
                        href="{{ route('projects.changelogs.create', $project) }}">New Entry</a>
                </div>
                <div class="bg-white shadow rounded divide-y">
                    @forelse($project->changelogs as $c)
                        <div class="p-3 flex items-center justify-between">
                            <div>
                                <div class="font-medium">Version {{ $c->version }} — {{ $c->status }}</div>
                                <div class="text-sm text-gray-600">Deploy: {{ $c->deploy_date ?? '—' }} • By:
                                    {{ optional($c->user)->name ?? '—' }} • Task:
                                    {{ optional($c->backlog)->task_name ?? '—' }}</div>
                            </div>
                            <div class="flex gap-3">
                                <a class="text-blue-600"
                                    href="{{ route('projects.changelogs.edit', [$project, $c]) }}">Edit</a>
                                <form method="POST" action="{{ route('projects.changelogs.destroy', [$project, $c]) }}"
                                    onsubmit="return confirm('Delete entry?')">@csrf @method('DELETE')<button
                                        class="text-red-600">Delete</button></form>
                            </div>
                        </div>
                    @empty
                        <div class="p-3 text-gray-500">No entries yet.</div>
                    @endforelse
                </div>
                <div class="mt-4">
                    <a class="px-3 py-2 bg-emerald-600 text-white rounded"
                        href="{{ route('projects.reminders.create', $project) }}">Schedule Reminder</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
