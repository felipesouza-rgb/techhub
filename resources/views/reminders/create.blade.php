<x-app-layout>
  <div class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Novo Reminder — {{ $project->name }}</h1>

    <form method="POST" action="{{ route('projects.reminders.store', $project) }}" class="space-y-4">
      @csrf

      <div>
        <label class="block mb-1">Stakeholder</label>
        <select name="stakeholder_id" class="w-full rounded border-gray-300" required>
          <option value="">Selecione…</option>
          @foreach($stakeholders as $s)
            <option value="{{ $s->id }}" @selected(old('stakeholder_id') == $s->id)>
              {{ $s->name }} — {{ $s->email }}
            </option>
          @endforeach
        </select>
        @error('stakeholder_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

        <p class="text-sm mt-1">
          <a href="{{ route('projects.stakeholders.create', $project) }}" class="text-indigo-600">Cadastrar novo stakeholder</a>
        </p>
      </div>

      <div>
        <label class="block mb-1">Data da notificação</label>
        <input type="date" name="notification_date" value="{{ old('notification_date') }}" class="w-full rounded border-gray-300" required>
        @error('notification_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div class="flex gap-2">
        <button class="px-4 py-2 rounded bg-indigo-600 text-white">Salvar</button>
        <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 rounded border">Cancelar</a>
      </div>
    </form>
  </div>
</x-app-layout>
