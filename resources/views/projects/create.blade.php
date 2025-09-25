<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">New Project</h1>
        <form method="POST" action="{{ route('projects.store') }}" class="space-y-4">@csrf
            <div><label class="block mb-1">Name</label><input name="name" class="w-full rounded border-gray-300"
                    value="{{ old('name') }}"></div>
            <div><label class="block mb-1">Description</label><textarea name="description" rows="3"
                    class="w-full rounded border-gray-300">{{ old('description') }}</textarea></div>
            <div><label class="block mb-1">Stakeholder name</label><input name="stakeholder_name"
                    class="w-full rounded border-gray-300" value="{{ old('stakeholder_name') }}"></div>
            <div><label class="block mb-1">Company</label><select name="company_id"
                    class="w-full rounded border-gray-300">@foreach($companies as $c)<option value="{{ $c->id }}">
                    {{ $c->name }}</option>@endforeach</select></div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
        </form>
    </div>
</x-app-layout>
