<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">New Task — {{ $project->name }}</h1>
        <form method="POST" action="{{ route('projects.backlogs.store', $project) }}" class="space-y-4">@csrf
            <div><label class="block mb-1">Name</label><input name="task_name" class="w-full rounded border-gray-300"
                    value="{{ old('task_name') }}"></div>
            <div><label class="block mb-1">Description</label><textarea name="description" rows="3"
                    class="w-full rounded border-gray-300">{{ old('description') }}</textarea></div>
            <div><label class="block mb-1">Type</label><select name="type" class="w-full rounded border-gray-300">
                    <option value="feature">Feature</option>
                    <option value="bugfix">Bugfix</option>
                    <option value="new screen">New Screen</option>
                </select></div>
            <div><label class="block mb-1">Status</label><select name="status" class="w-full rounded border-gray-300">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="done">Done</option>
                </select></div>
            <div><label class="block mb-1">Assignee</label><select name="assigned_to"
                    class="w-full rounded border-gray-300">
                    <option value="">—</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}
                    </option>@endforeach
                </select></div>
            <div><label class="block mb-1">Priority (1=high, 5=low)</label><input type="number" min="1" max="5"
                    name="priority" class="w-full rounded border-gray-300" value="{{ old('priority', 3) }}"></div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
        </form>
    </div>
</x-app-layout>
