<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Projects</h1><a class="px-4 py-2 bg-indigo-600 text-white rounded"
                href="{{ route('projects.create') }}">New</a>
        </div>
        @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>@endif
        <div class="bg-white shadow rounded">
            <table class="min-w-full divide-y">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4">Company</th>
                        <th class="px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($projects as $p)
                        <tr>
                            <td class="px-4 py-2"><a class="text-blue-600"
                                    href="{{ route('projects.show', $p) }}">{{ $p->name }}</a></td>
                            <td class="px-4 py-2">{{ $p->company->name }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a class="text-blue-600" href="{{ route('projects.edit', $p) }}">Edit</a>
                                <form method="POST" action="{{ route('projects.destroy', $p) }}"
                                    onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                                        class="text-red-600">Delete</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $projects->links() }}</div>
    </div>
</x-app-layout>
