<x-app-layout>
<div class="max-w-6xl mx-auto p-6">
<div class="flex items-center justify-between mb-6">
<h1 class="text-2xl font-semibold">Users</h1>
<a href="{{ route('users.create') }}" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">New User</a>
</div>


@if (session('success'))
<div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
@endif


<form method="GET" class="mb-4 flex gap-2">
<input name="q" value="{{ $q ?? '' }}" placeholder="Search by name or email" class="w-full rounded border-gray-300" />
<button class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">Search</button>
</form>


<div class="bg-white dark:bg-gray-900 shadow rounded overflow-hidden">
<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
<thead class="bg-gray-50 dark:bg-gray-800">
<tr>
<th class="px-4 py-3 text-left text-sm font-medium">Name</th>
<th class="px-4 py-3 text-left text-sm font-medium">Email</th>
<th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
@forelse ($users as $user)
<tr>
<td class="px-4 py-3">{{ $user->name }}</td>
<td class="px-4 py-3">{{ $user->email }}</td>
<td class="px-4 py-3 text-right">
<a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:underline mr-3">View</a>
<a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:underline mr-3">Edit</a>
<form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
@csrf
@method('DELETE')
<button class="text-red-600 hover:underline" onclick="return confirm('Delete this user?')">Delete</button>
</form>
</td>
</tr>
@empty
<tr>
<td colspan="3" class="px-4 py-6 text-center text-gray-500">No users found.</td>
</tr>
@endforelse
</tbody>
</table>
</div>


<div class="mt-4">{{ $users->links() }}</div>
</div>
</x-app-layout>
