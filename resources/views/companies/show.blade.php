<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 space-y-6">
        {{-- Header / Ações --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">{{ $company->name }}</h1>
                <p class="text-sm text-gray-500">Company details and related projects</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('companies.edit', $company) }}"
                   class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Edit Company</a>

                {{-- Dica: se seu form de create de projeto aceitar ?company_id= --}}
                <a href="{{ route('projects.create', ['company_id' => $company->id]) }}"
                   class="px-3 py-2 rounded bg-green-600 text-white hover:bg-green-700">New Project</a>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card com info da empresa (adicione mais campos se tiver) --}}
        <div class="bg-white shadow rounded p-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <div class="text-sm text-gray-500">Name</div>
                <div class="font-medium">{{ $company->name }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Projects</div>
                <div class="font-medium">{{ $projects->total() }}</div>
            </div>
            {{-- coloque outros campos da company aqui, se existirem --}}
        </div>

        {{-- Lista de projetos da empresa --}}
        <div class="bg-white shadow rounded">
            <div class="px-4 py-3 border-b">
                <h2 class="font-semibold">Projects from {{ $company->name }}</h2>
            </div>

            <table class="min-w-full divide-y">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Project</th>
                        <th class="px-4 py-2 text-left">Stakeholder</th>
                        <th class="px-4 py-2 text-left">Backlogs</th>
                        <th class="px-4 py-2 text-left">Changelogs</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($projects as $p)
                        <tr>
                            <td class="px-4 py-2">
                                {{-- Clicar no projeto → projects.show --}}
                                <a class="text-blue-600" href="{{ route('projects.show', $p) }}">
                                    {{ $p->name }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                {{ $p->stakeholder_name ?? '—' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $p->backlogs_count ?? '0' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $p->changelogs_count ?? '0' }}
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex gap-3 justify-end">
                                    <a class="text-blue-600" href="{{ route('projects.show', $p) }}">Open</a>
                                    <a class="text-blue-600" href="{{ route('projects.edit', $p) }}">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-gray-500" colspan="5">
                                No projects yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
