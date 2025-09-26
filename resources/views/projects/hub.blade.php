<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">
                {{ $company->name }} • {{ $project->name }} — Hub
            </h1>
            <p class="text-sm text-gray-500">Atalhos rápidos para este projeto.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {{-- Criar Backlog --}}
            <a href="{{ route('projects.backlogs.create', $project) }}"
               class="block p-4 rounded-lg shadow bg-white hover:shadow-md">
                <div class="font-medium">Novo Backlog</div>
                <div class="text-sm text-gray-500">Criar task no backlog deste projeto</div>
            </a>

            {{-- Listar Backlogs --}}
            <a href="{{ route('projects.backlogs.index', $project) }}"
               class="block p-4 rounded-lg shadow bg-white hover:shadow-md">
                <div class="font-medium">Backlogs</div>
                <div class="text-sm text-gray-500">Ver/gerenciar backlog</div>
            </a>

            {{-- Criar Changelog --}}
            <a href="{{ route('projects.changelogs.create', $project) }}"
               class="block p-4 rounded-lg shadow bg-white hover:shadow-md">
                <div class="font-medium">Novo Changelog</div>
                <div class="text-sm text-gray-500">Registrar alterações</div>
            </a>

            {{-- Listar Changelogs --}}
            <a href="{{ route('projects.changelogs.index', $project) }}"
               class="block p-4 rounded-lg shadow bg-white hover:shadow-md">
                <div class="font-medium">Changelogs</div>
                <div class="text-sm text-gray-500">Histórico de alterações</div>
            </a>

            {{-- Criar Reminder (se tiver essa tela) --}}
            @if (Route::has('projects.reminders.create'))
                <a href="{{ route('projects.reminders.create', $project) }}"
                   class="block p-4 rounded-lg shadow bg-white hover:shadow-md">
                    <div class="font-medium">Novo Reminder</div>
                    <div class="text-sm text-gray-500">Agendar lembrete para stakeholders</div>
                </a>
            @endif

            {{-- Ações extras (Mailpit / Dispatch Sync em dev, se quiser linkar docs internos) --}}
        </div>

        <div class="mt-8 grid md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-2">Backlogs recentes</h2>
                <div class="bg-white rounded shadow divide-y">
                    @forelse($project->backlogs->take(5) as $b)
                        <div class="p-3">
                            <div class="font-medium">{{ $b->task_name }}</div>
                            <div class="text-sm text-gray-500">{{ $b->status }} · {{ $b->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    @empty
                        <div class="p-3 text-sm text-gray-500">Nenhum backlog ainda.</div>
                    @endforelse
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-2">Changelogs recentes</h2>
                <div class="bg-white rounded shadow divide-y">
                    @forelse($project->changelogs->take(5) as $c)
                        <div class="p-3">
                            <div class="font-medium">{{ $c->title ?? 'Change' }}</div>
                            <div class="text-sm text-gray-500">{{ $c->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    @empty
                        <div class="p-3 text-sm text-gray-500">Nenhum changelog ainda.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
