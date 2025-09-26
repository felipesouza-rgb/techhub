<x-app-layout>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">New Task — {{ $project->name }}</h1>

    @if ($errors->any())
      <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
        <ul class="list-disc ml-5">
          @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('projects.backlogs.store', $project) }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm mb-1">Task name</label>
        <input name="task_name" value="{{ old('task_name') }}" class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block text-sm mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description') }}</textarea>
      </div>

      <div>
        <label class="block text-sm mb-1">Type</label>
        <select name="type" class="w-full border rounded p-2" required>
          @foreach (['feature','bugfix','new screen'] as $t)
            <option value="{{ $t }}" @selected(old('type')===$t)>{{ $t }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm mb-1">Status</label>
        <select name="status" class="w-full border rounded p-2" required>
          @foreach (['pending','in_progress','done'] as $s)
            <option value="{{ $s }}" @selected(old('status')===$s)>{{ $s }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm mb-1">Assigned to</label>
        <select name="assigned_to" class="w-full border rounded p-2">
          <option value="">— No assignee —</option>
          @foreach ($users as $u)
            <option value="{{ $u->id }}" @selected(old('assigned_to')==$u->id)>{{ $u->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm mb-1">Priority (1–5)</label>
        <input type="number" min="1" max="5" name="priority" value="{{ old('priority',3) }}" class="w-full border rounded p-2" required>
      </div>

      <div class="flex gap-2">
        <button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Create</button>
        <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 rounded border">Cancel</a>
      </div>
    </form>
  </div>
</x-app-layout>
