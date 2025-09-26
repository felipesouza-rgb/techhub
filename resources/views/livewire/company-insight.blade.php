<div class="space-y-6">
   {{--  --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Company: {{ $company->name }}</h1>
            <p class="text-sm text-gray-500">Visão consolidada de Backlogs, Changelogs e Reminders desta empresa.</p>
        </div>
        <a href="{{ route('companies.index') }}" class="text-sm text-indigo-600 hover:underline">← Voltar</a>
    </div>

    {{-- Tabs --}}
    <div class="flex items-center gap-2">
        <button wire:click="switchTab('backlogs')"
            class="px-3 py-1.5 rounded-lg border text-sm {{ $tab==='backlogs' ? 'bg-indigo-600 text-white border-indigo-600' : 'hover:bg-gray-50' }}">
            Backlogs
        </button>
        <button wire:click="switchTab('changelogs')"
            class="px-3 py-1.5 rounded-lg border text-sm {{ $tab==='changelogs' ? 'bg-indigo-600 text-white border-indigo-600' : 'hover:bg-gray-50' }}">
            Changelogs
        </button>
        <button wire:click="switchTab('reminders')"
            class="px-3 py-1.5 rounded-lg border text-sm {{ $tab==='reminders' ? 'bg-indigo-600 text-white border-indigo-600' : 'hover:bg-gray-50' }}">
            Reminders
        </button>
    </div>

    {{-- Filtros globais --}}
    <div class="flex items-center gap-3 flex-wrap">
        <input type="text" placeholder="Buscar..."
               wire:model.debounce.400ms="search"
               class="w-72 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />

        @if ($tab === 'backlogs')
            <select wire:model.live="status"
                    class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="all">All statuses</option>
                <option value="todo">To do</option>
                <option value="doing">Doing</option>
                <option value="done">Done</option>
            </select>
        @endif

        <select wire:model.live="perPage"
                class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="5">5 / page</option>
            <option value="10">10 / page</option>
            <option value="25">25 / page</option>
            <option value="50">50 / page</option>
        </select>
    </div>

    {{-- Conteúdo por aba --}}
    @if ($tab === 'backlogs')
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-800 text-left text-sm text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-5 py-3">Task</th>
                        <th class="px-5 py-3">Project</th>
                        <th class="px-5 py-3">Assignee</th>
                        <th class="px-5 py-3">Type</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($backlogs as $b)
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/50">
                            <td class="px-5 py-3">
                                <div class="font-medium">{{ $b->task_name }}</div>
                                <div class="text-xs text-gray-500 line-clamp-1">{{ $b->description }}</div>
                            </td>
                            <td class="px-5 py-3 text-sm">{{ $b->project?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-sm">{{ $b->assignee?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-xs">
                                <span class="inline-flex items-center rounded-full border px-2 py-0.5">{{ ucfirst($b->type) }}</span>
                            </td>
                            <td class="px-5 py-3 text-xs">
                                @php
                                    $badge = [
                                        'todo' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                        'doing' => 'bg-amber-100 text-amber-700',
                                        'done' => 'bg-emerald-100 text-emerald-700',
                                    ][$b->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 {{ $badge }}">
                                    {{ ucfirst($b->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-500">{{ $b->created_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-6 text-center text-sm text-gray-500">Nenhum backlog encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-5 py-4">
                {{ $backlogs->links() }}
            </div>
        </div>
    @elseif ($tab === 'changelogs')
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow overflow-hidden">
            <ul class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($changelogs as $c)
                    <li class="px-5 py-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-medium">{{ $c->title ?? 'Change' }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    {{ $c->description }}
                                </div>
                                <div class="mt-2 flex items-center gap-2 text-xs">
                                    <span class="rounded-full bg-gray-100 dark:bg-gray-800 px-2 py-0.5">Project: {{ $c->project?->name ?? '—' }}</span>
                                    <span class="rounded-full bg-gray-100 dark:bg-gray-800 px-2 py-0.5">Version: {{ $c->version ?? '—' }}</span>
                                    <span class="rounded-full bg-gray-100 dark:bg-gray-800 px-2 py-0.5">By: {{ $c->user?->name ?? '—' }}</span>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $c->created_at?->diffForHumans() }}</span>
                        </div>
                    </li>
                @empty
                    <li class="px-5 py-6 text-center text-sm text-gray-500">Nenhum changelog encontrado.</li>
                @endforelse
            </ul>

            <div class="px-5 py-4">
                {{ $changelogs->links() }}
            </div>
        </div>
    @else
        {{-- Reminders --}}
        <div class="rounded-2xl border border-dashed p-8 text-center text-sm text-gray-500">
            @if (is_iterable($reminders) && count($reminders))
                {{-- Se você já tiver reminders, renderize parecido com as outras abas --}}
            @else
                <p>Nenhum reminder configurado ou modelo ainda não criado.</p>
                <p class="mt-2">Veja abaixo como criar a tabela/modelo de Reminders (passo 6).</p>
            @endif
        </div>
    @endif
</div>
