<x-app-layout>
<div class="max-w-2xl mx-auto p-6">
<h1 class="text-2xl font-semibold mb-6">Edit User</h1>


<form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
@csrf
@method('PUT')
@include('users._form',['user' => $user])


<div class="flex justify-end gap-2">
<a href="{{ route('users.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">Cancel</a>
<button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
</div>
</form>
</div>
</x-app-layout>
