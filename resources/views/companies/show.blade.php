<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 space-y-6">
        <livewire:company-insight :company="$company" />
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Company: {{ $company->name }}</h1>
            <a href="{{ route('companies.index') }}"
               class="text-sm text-indigo-600 hover:underline">← Back</a>
        </div>

        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow p-6 space-y-4">
            <div>
                <div class="text-sm text-gray-500">ID</div>
                <div class="font-medium">#{{ $company->id }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Name</div>
                <div class="font-medium">{{ $company->name }}</div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm text-gray-500">
                <div>Created: {{ $company->created_at?->format('d/m/Y H:i') }}</div>
                <div>Updated: {{ $company->updated_at?->format('d/m/Y H:i') }}</div>
            </div>

            <div class="pt-4 flex items-center gap-2">
                <a href="{{ route('companies.edit', $company) }}"
                   class="px-3 py-2 rounded-lg border hover:bg-gray-50 dark:hover:bg-gray-800 text-sm">
                    Edit
                </a>
                <form action="{{ route('companies.destroy', $company) }}" method="POST"
                      onsubmit="return confirm('Remover esta empresa?');">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-2 rounded-lg border text-red-600 hover:bg-red-50 text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
