<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">New Changelog — {{ $project->name }}</h1>
        <form method="POST" action="{{ route('projects.changelogs.store', $project) }}" class="space-y-4">@csrf
            <div><label class="block mb-1">Version</label><input name="version" class="w-full rounded border-gray-300"
                    value="{{ old('version') }}"></div>
            <div><label class="block mb-1">Status</label><select name="status" class="w-full rounded border-gray-300">
                    <option value="deploy_pending">Deploy Pending</option>
                    <option value="deployed">Deployed</option>
                    <option value="rollback">Rollback</option>
                </select></div>
            <div><label class="block mb-1">Deploy Date</label><input type="date" name="deploy_date"
                    class="w-full rounded border-gray-300" value="{{ old('deploy_date') }}"></div>
            <div><label class="block mb-1">Executed By (user)</label><select name="user_id"
                    class="w-full rounded border-gray-300">
                    <option value="">—</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}
                    </option>@endforeach
                </select></div>
            <div><label class="block mb-1">Related Task (backlog)</label><select name="backlog_id"
                    class="w-full rounded border-gray-300">
                    <option value="">—</option>@foreach($backlogs as $b)<option value="{{ $b->id }}">#{{ $b->id }} —
                    {{ $b->task_name }}</option>@endforeach
                </select></div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
        </form>
    </div>
</x-app-layout>
