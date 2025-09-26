<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">{{ $company->name }} — Dashboard</h1>
            <p class="text-sm text-gray-500">Visão geral de projetos, backlogs e changelogs desta empresa.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded shadow p-4">
                <div class="font-semibold mb-2">Projetos</div>
                <ul class="space-y-2">
                    @forelse($company->projects as $project)
                        <li class="flex items-center justify-between">
                            <span>{{ $project->name }}</span>
                            <a href="{{ route('projects.hub', [$company, $project]) }}"
                               class="text-sm text-indigo-600 hover:underline">Abrir Hub</a>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Sem projetos ainda.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white rounded shadow p-4">
                <div class="font-semibold mb-2">Backlogs recentes</div>
                <div class="divide-y">
                    @forelse($recentBacklogs as $b)
                        <div class="py-2">
                            <div class="font-medium text-sm">{{ $b->task_name }}</div>
                            <div class="text-xs text-gray-500">
                                Projeto: {{ $b->project->name }} • {{ $b->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500">Nada por aqui ainda.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded shadow p-4">
                <div class="font-semibold mb-2">Changelogs recentes</div>
                <div class="divide-y">
                    @forelse($recentChangelogs as $c)
                        <div class="py-2">
                            <div class="font-medium text-sm">{{ $c->title ?? 'Change' }}</div>
                            <div class="text-xs text-gray-500">
                                Projeto: {{ $c->project->name }} • {{ $c->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500">Nada por aqui ainda.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
