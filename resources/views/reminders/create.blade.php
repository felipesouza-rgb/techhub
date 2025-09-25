<x-app-layout>
    <div class="max-w-md mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Schedule Reminder — {{ $project->name }}</h1>
        <form method="POST" action="{{ route('projects.reminders.store', $project) }}" class="space-y-4">@csrf
            <div><label class="block mb-1">Stakeholder (user)</label><select name="stakeholder_user_id"
                    class="w-full rounded border-gray-300">@foreach($users as $u)<option value="{{ $u->id }}">
                    {{ $u->name }} ({{ $u->email }})</option>@endforeach</select></div>
            <div><label class="block mb-1">Notification date</label><input type="date" name="notification_date"
                    class="w-full rounded border-gray-300" value="{{ old('notification_date') }}"></div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
        </form>
    </div>
</x-app-layout>
