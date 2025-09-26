<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Título + ações / filtros --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">Projects</h1>
            <p class="text-sm text-gray-500">Gerencie projetos, filtre por empresa e edite rapidamente.</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <select wire:model.live="perPage"
                    class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="5">5 / page</option>
                <option value="10">10 / page</option>
                <option value="25">25 / page</option>
                <option value="50">50 / page</option>
            </select>

            <select wire:model.live="companyFilter"
                    class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Companies</option>
                @foreach($companies as $comp)
                    <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                @endforeach
            </select>

            <input type="text" placeholder="Buscar por nome, descrição, stakeholder..."
                   wire:model.debounce.300ms="search"
                   class="w-72 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />

            <button wire:click="create"
                    class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 text-sm">
                New Project
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
                    <th class="px-5 py-3">Company</th>
                    <th class="px-5 py-3">
                        <button class="inline-flex items-center gap-1" wire:click="sortBy('created_at')">
                            Created
                            @if ($sortField === 'created_at')
                                <x-sort-icon :dir="$sortDir" />
                            @endif
                        </button>
                    </th>
                    <th class="px-5 py-3 w-48">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($projects as $p)
                    <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/50">
                        <td class="px-5 py-3">
                            <div class="font-medium">{{ $p->name }}</div>
                            <div class="text-xs text-gray-500 line-clamp-1">{{ $p->description }}</div>
                            <div class="text-xs text-gray-500">#{{ $p->id }}</div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-sm">{{ $p->company?->name ?? '—' }}</span>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-500">
                            {{ $p->created_at?->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                {{-- Evite show se não implementou; use edit --}}
                                <a href="{{ route('projects.edit', $p) }}"
                                   class="px-2 py-1 text-xs rounded-lg border hover:bg-gray-50 dark:hover:bg-gray-800">
                                    Edit
                                </a>

                                <button wire:click="confirmDelete({{ $p->id }})"
                                   class="px-2 py-1 text-xs rounded-lg border text-red-600 hover:bg-red-50">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-sm text-gray-500">
                            Nenhum projeto encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-5 py-4">
            {{ $projects->links() }}
        </div>
    </div>

    {{-- Modal Create/Edit --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('showModal', false)"></div>

            <div class="relative w-full max-w-lg rounded-2xl bg-white dark:bg-gray-900 shadow-lg p-6 space-y-4">
                <h2 class="text-lg font-semibold">
                    {{ $editingId ? 'Edit Project' : 'New Project' }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-sm">Name</label>
                        <input type="text" wire:model.defer="name"
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm">Company</label>
                        <select wire:model.defer="company_id"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Selecione...</option>
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm">Stakeholder</label>
                        <input type="text" wire:model.defer="stakeholder_name"
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('stakeholder_name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-sm">Description</label>
                        <textarea rows="4" wire:model.defer="description"
                                  class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                        @error('description') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>
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

    {{-- Modal confirmação Delete --}}
    @if ($confirmingDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="cancelDelete"></div>

            <div class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold">Remover projeto?</h3>
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
