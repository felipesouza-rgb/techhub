<x-app-layout>
  <div class="max-w-4xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-2xl font-semibold">Stakeholders — {{ $project->name }}</h1>
      <a href="{{ route('projects.stakeholders.create', $project) }}"
         class="px-4 py-2 rounded bg-indigo-600 text-white">Novo</a>
    </div>

    @if (session('success'))
      <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium">Nome</th>
            <th class="px-4 py-3 text-left text-sm font-medium">E-mail</th>
            <th class="px-4 py-3 text-left text-sm font-medium">Função</th>
            <th class="px-4 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse($stakeholders as $s)
            <tr>
              <td class="px-4 py-2">{{ $s->name }}</td>
              <td class="px-4 py-2">{{ $s->email }}</td>
              <td class="px-4 py-2">{{ $s->role }}</td>
              <td class="px-4 py-2 text-right space-x-2">
                <a class="text-indigo-600" href="{{ route('projects.stakeholders.edit', [$project, $s]) }}">Editar</a>
                <form action="{{ route('projects.stakeholders.destroy', [$project, $s]) }}" method="POST" class="inline">
                  @csrf @method('DELETE')
                  <button class="text-red-600" onclick="return confirm('Remover?')">Remover</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td class="px-4 py-6 text-gray-500" colspan="4">Nenhum stakeholder.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $stakeholders->links() }}</div>
  </div>
</x-app-layout>
