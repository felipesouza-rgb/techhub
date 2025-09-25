<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Companies</h1>
            <a href="{{ route('companies.create') }}" class="px-4 py-2 rounded bg-indigo-600 text-white">New</a>
        </div>
        @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>@endif
        <div class="bg-white shadow rounded">
            <table class="min-w-full divide-y">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($companies as $c)
                        <tr>
                            <td class="px-4 py-2">{{ $c->name }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a class="text-blue-600" href="{{ route('companies.edit', $c) }}">Edit</a>
                                <form method="POST" action="{{ route('companies.destroy', $c) }}"
                                    onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                                        class="text-red-600">Delete</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $companies->links() }}</div>
    </div>
</x-app-layout>
