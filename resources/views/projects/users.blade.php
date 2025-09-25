<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 space-y-4">
        @if(session('success'))
        <div class="p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>@endif
        <h1 class="text-2xl font-semibold">Users in {{ $project->name }}</h1>
        <div class="bg-white shadow rounded p-4">
            <h2 class="font-semibold mb-2">Current Members</h2>
            <ul class="list-disc ml-5">
                @forelse($project->users as $u)
                    <li class="flex items-center justify-between">
                        <span>{{ $u->name }} ({{ $u->email }})</span>
                        <form method="POST" action="{{ route('projects.users.detach', [$project, $u]) }}">@csrf
                            @method('DELETE')<button class="text-red-600">Remove</button></form>
                    </li>
                @empty
                    <li class="text-gray-500">No members.</li>
                @endforelse
            </ul>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h2 class="font-semibold mb-2">Add Member</h2>
            <div class="space-y-2">
                @foreach($allUsers as $user)
                    <form class="flex items-center justify-between" method="POST"
                        action="{{ route('projects.users.attach', [$project, $user]) }}">@csrf
                        <span>{{ $user->name }} ({{ $user->email }})</span>
                        <button class="text-indigo-600">Add</button>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
