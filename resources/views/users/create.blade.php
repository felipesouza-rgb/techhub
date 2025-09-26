<x-app-layout>
<div class="max-w-2xl mx-auto p-6">
<h1 class="text-2xl font-semibold mb-6">New User</h1>


<form method="POST" action="{{ route('users.store') }}" class="space-y-6">
@csrf
@include('users._form')


<div class="flex justify-end gap-2">
<a href="{{ route('users.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">Cancel</a>
<button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Create</button>
</div>
</form>
</div>
</x-app-layout>
