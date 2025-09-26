<x-app-layout>
<div class="max-w-3xl mx-auto p-6 space-y-6">
<div class="flex items-center justify-between">
<h1 class="text-2xl font-semibold">User Details</h1>
<div class="flex items-center gap-3">
<a href="{{ route('users.edit', $user) }}" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Edit</a>
<a href="{{ route('users.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">Back</a>
</div>
</div>


<div class="bg-white dark:bg-gray-900 shadow rounded p-6">
<dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<dt class="text-sm text-gray-500">Name</dt>
<dd class="text-base">{{ $user->name }}</dd>
</div>
<div>
<dt class="text-sm text-gray-500">Email</dt>
<dd class="text-base">{{ $user->email }}</dd>
</div>
@if(method_exists($user, 'trashed'))
<div>
<dt class="text-sm text-gray-500">Deleted?</dt>
<dd class="text-base">{{ $user->trashed() ? 'Yes' : 'No' }}</dd>
</div>
@endif
<div class="md:col-span-2">
<dt class="text-sm text-gray-500">Created At</dt>
<dd class="text-base">{{ $user->created_at }}</dd>
</div>
</dl>
</div>
</div>
</x-app-layout>
