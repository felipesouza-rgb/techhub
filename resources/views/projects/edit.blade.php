{{-- resources/views/projects/edit.blade.php --}}
<x-app-layout>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Edit Project</h1>

    <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-4">
      @csrf
      @method('PUT') {{-- ISSO É O QUE FALTAVA! --}}

      <div>
        <label class="block text-sm mb-1">Name</label>
        <input type="text" name="name" class="w-full border rounded p-2"
               value="{{ old('name', $project->name) }}" required>
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm mb-1">Description</label>
        <textarea name="description" class="w-full border rounded p-2" rows="4">{{ old('description', $project->description) }}</textarea>
        @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm mb-1">Stakeholder</label>
        <input type="text" name="stakeholder_name" class="w-full border rounded p-2"
               value="{{ old('stakeholder_name', $project->stakeholder_name) }}">
        @error('stakeholder_name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm mb-1">Company</label>
        <select name="company_id" class="w-full border rounded p-2" required>
          @foreach($companies as $company)
            <option value="{{ $company->id }}" @selected(old('company_id', $project->company_id) == $company->id)>
              {{ $company->name }}
            </option>
          @endforeach
        </select>
        @error('company_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div class="flex gap-2">
        <button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
        <a href="{{ route('projects.index') }}" class="px-4 py-2 rounded border">Cancel</a>
      </div>
    </form>
  </div>
</x-app-layout>
