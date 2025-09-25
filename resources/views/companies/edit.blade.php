<x-app-layout>
    <div class="max-w-md mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Edit Company</h1>
        <form method="POST" action="{{ route('companies.update', $company) }}" class="space-y-4">@csrf @method('PUT')
            <div><label class="block mb-1">Name</label><input name="name" class="w-full rounded border-gray-300"
                    value="{{ old('name', $company->name) }}"></div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
        </form>
    </div>
</x-app-layout>
