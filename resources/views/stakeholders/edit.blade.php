<x-app-layout>
  <div class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Novo Stakeholder — {{ $project->name }}</h1>

    <form method="POST" action="{{ route('projects.stakeholders.update', $project) }}" class="space-y-4">
      @csrf
      @method('PUT')
      <div>
        <label class="block mb-1">Nome</label>
        <input name="name" value="{{ old('name') }}" class="w-full rounded border-gray-300">
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block mb-1">E-mail</label>
        <input name="email" value="{{ old('email') }}" class="w-full rounded border-gray-300">
        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block mb-1">Função (opcional)</label>
        <input name="role" value="{{ old('role') }}" class="w-full rounded border-gray-300">
      </div>

      <div class="flex gap-2">
        <button class="px-4 py-2 rounded bg-indigo-600 text-white">Salvar</button>
        <a href="{{ route('projects.stakeholders.index', $project) }}" class="px-4 py-2 rounded border">Cancelar</a>
      </div>
    </form>
  </div>
</x-app-layout>
