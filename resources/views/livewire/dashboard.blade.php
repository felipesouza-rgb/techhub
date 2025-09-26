<div class="max-w-7xl mx-auto p-6 space-y-8">
    <div class="flex items-center justify-between gap-4">
        <h1 class="text-2xl font-semibold">Dashboard</h1>

        <div class="flex items-center gap-3">
            <input
                type="text"
                wire:model.debounce.500ms="search"
                placeholder="Search (tasks, changelogs...)"
                class="w-64 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />

            <select
                wire:model="status"
                class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
                <option value="all">All statuses</option>
                <option value="todo">To do</option>
                <option value="doing">Doing</option>
                <option value="done">Done</option>
            </select>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-4">
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow p-4">
            <p class="text-sm text-gray-500">Companies</p>
            <p class="text-3xl font-bold mt-1">{{ $counts['companies'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow p-4">
            <p class="text-sm text-gray-500">Projects</p>
            <p class="text-3xl font-bold mt-1">{{ $counts['projects'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow p-4">
            <p class="text-sm text-gray-500">Backlogs</p>
            <p class="text-3xl font-bold mt-1">{{ $counts['backlogs'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow p-4">
            <p class="text-sm text-gray-500">Done Backlogs</p>
            <p class="text-3xl font-bold mt-1 text-emerald-600">{{ $counts['done_backlogs'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow p-4">
            <p class="text-sm text-gray-500">Changelogs</p>
            <p class="text-3xl font-bold mt-1">{{ $counts['changelogs'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Recent Backlogs --}}
    <div class="rounded-2xl bg-white dark:bg-gray-900 shadow">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Recent Backlogs</h2>
            <a href="{{ route('projects.index') }}"
               class="text-sm text-indigo-600 hover:underline">Go to Projects</a>
        </div>

        <div class="overflow-x-auto">
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
                    @forelse($recentBacklogs as $b)
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/50">
                            <td class="px-5 py-3">
                                <div class="font-medium">{{ $b->task_name }}</div>
                                <div class="text-xs text-gray-500 line-clamp-1">{{ $b->description }}</div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm">{{ $b->project?->name ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm">{{ $b->assignee?->name ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs">
                                    {{ ucfirst($b->type) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                @php
                                    $badge = [
                                        'todo' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                        'doing' => 'bg-amber-100 text-amber-700',
                                        'done' => 'bg-emerald-100 text-emerald-700',
                                    ][$b->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs {{ $badge }}">
                                    {{ ucfirst($b->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-500">
                                {{ $b->created_at?->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-6 text-center text-sm text-gray-500">Nothing here yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($recentBacklogs) >= $limit)
            <div class="p-4">
                <button wire:click="loadMore"
                        class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white py-2 text-sm">
                    Load more
                </button>
            </div>
        @endif
    </div>

    {{-- Recent Changelogs --}}
    <div class="rounded-2xl bg-white dark:bg-gray-900 shadow">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Recent Changelogs</h2>
            <a href="{{ route('projects.index') }}"
               class="text-sm text-indigo-600 hover:underline">Go to Projects</a>
        </div>

        <ul class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($recentChangelogs as $c)
                <li class="px-5 py-4 flex items-start gap-4">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                        <span class="text-sm font-bold">{{ strtoupper(substr($c->project?->name ?? 'T',0,2)) }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div class="font-medium">{{ $c->title ?? 'Change' }}</div>
                            <span class="text-xs text-gray-500">{{ $c->created_at?->diffForHumans() }}</span>
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                            {{ $c->description }}
                        </div>
                        <div class="mt-2 flex items-center gap-2 text-xs">
                            <span class="rounded-full bg-gray-100 dark:bg-gray-800 px-2 py-0.5">
                                Project: {{ $c->project?->name ?? '—' }}
                            </span>
                            <span class="rounded-full bg-gray-100 dark:bg-gray-800 px-2 py-0.5">
                                Version: {{ $c->version ?? '—' }}
                            </span>
                            <span class="rounded-full bg-gray-100 dark:bg-gray-800 px-2 py-0.5">
                                By: {{ $c->user?->name ?? '—' }}
                            </span>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-5 py-6 text-center text-sm text-gray-500">No changelogs yet.</li>
            @endforelse
        </ul>

        @if(count($recentChangelogs) >= $limit)
            <div class="p-4">
                <button wire:click="loadMore"
                        class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white py-2 text-sm">
                    Load more
                </button>
            </div>
        @endif
    </div>
</div>
