<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Título + ações --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">Companies</h1>
            <p class="text-sm text-gray-500"></p>
        </div>

        <div class="flex items-center gap-2">
            <select wire:model.live="perPage"
                    class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="5">5 / page</option>
                <option value="10">10 / page</option>
                <option value="25">25 / page</option>
                <option value="50">50 / page</option>
            </select>

            <input type="text" placeholder="Buscar por nome..."
                   wire:model.debounce.300ms="search"
                   class="w-64 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />

            <button wire:click="create"
                    class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 text-sm">
                New Company
            </button>
        </div>
    </div>

    {{-- Alertas --}}
    @if (session('success'))
        <div class="rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabela --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-800 text-left text-sm text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-5 py-3">
                        <button class="inline-flex items-center gap-1" wire:click="sortBy('name')">
                            Name
                            @if ($sortField === 'name')
                                <x-sort-icon :dir="$sortDir" />
                            @endif
                        </button>
                    </th>
                    <th class="px-5 py-3">
                        <button class="inline-flex items-center gap-1" wire:click="sortBy('created_at')">
                            Created
                            @if ($sortField === 'created_at')
                                <x-sort-icon :dir="$sortDir" />
                            @endif
                        </button>
                    </th>
                    <th class="px-5 py-3 w-40">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($companies as $c)
                    <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/50">
                        <td class="px-5 py-3">
                            <div class="font-medium">{{ $c->name }}</div>
                            <div class="text-xs text-gray-500">#{{ $c->id }}</div>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-500">
                            {{ $c->created_at?->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                {{-- Use edit para evitar erro se o show não existir --}}
                                <a href="{{ route('companies.show', $c) }}"
                                   class="px-2 py-1 text-xs rounded-lg border hover:bg-gray-50 dark:hover:bg-gray-800">
                                    Edit
                                </a>

                                <button wire:click="confirmDelete({{ $c->id }})"
                                   class="px-2 py-1 text-xs rounded-lg border text-red-600 hover:bg-red-50">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-5 py-6 text-center text-sm text-gray-500">
                            Nenhuma empresa encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-5 py-4">
            {{ $companies->links() }}
        </div>
    </div>

    {{-- Modal de Create/Edit --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('showModal', false)"></div>

            <div class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-lg p-6 space-y-4">
                <h2 class="text-lg font-semibold">
                    {{ $editingId ? 'Edit Company' : 'New Company' }}
                </h2>

                <div class="space-y-2">
                    <label class="text-sm">Name</label>
                    <input type="text" wire:model.defer="name"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button wire:click="$set('showModal', false)"
                            class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-50 dark:hover:bg-gray-800">
                        Cancel
                    </button>
                    <button wire:click="save"
                            class="px-4 py-2 text-sm rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">
                        Save
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal de confirmação de Delete (Livewire puro) --}}
    @if ($confirmingDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="cancelDelete"></div>

            <div class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold">Remover empresa?</h3>
                <p class="text-sm text-gray-600">Esta ação não pode ser desfeita.</p>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-50 dark:hover:bg-gray-800"
                            wire:click="cancelDelete">
                        Cancelar
                    </button>
                    <button class="px-4 py-2 text-sm rounded-lg bg-red-600 hover:bg-red-700 text-white"
                            wire:click="deleteConfirmed">
                        Remover
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
