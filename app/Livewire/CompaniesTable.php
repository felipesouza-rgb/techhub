<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Company;

class CompaniesTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDir = 'desc';
    public int $perPage = 10;

    // Modal de create/edit
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';

    // Modal de confirmação de delete (Livewire puro)
    public ?int $confirmingDeleteId = null;

    protected $rules = [
        'name' => 'required|string|min:2|max:100',
    ];

    protected $messages = [
        'name.required' => 'O nome é obrigatório.',
        'name.min'      => 'Mínimo de 2 caracteres.',
        'name.max'      => 'Máximo de 100 caracteres.',
    ];

    // Resetar paginação quando filtros mudarem
    public function updatedSearch()   { $this->resetPage(); }
    public function updatedPerPage()  { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDir = 'asc';
        }
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $company = Company::findOrFail($id);
        $this->editingId = $company->id;
        $this->name = $company->name ?? '';
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editingId) {
            $company = Company::findOrFail($this->editingId);
            $company->update(['name' => $this->name]);
            session()->flash('success', 'Empresa atualizada com sucesso!');
        } else {
            Company::create(['name' => $this->name]);
            session()->flash('success', 'Empresa criada com sucesso!');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    // --- Confirmação de Delete (sem Alpine/JS) ---
    public function confirmDelete(int $id): void
    {
        $this->confirmingDeleteId = $id; // abre modal de confirmação
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeleteId = null; // fecha modal
    }

    public function deleteConfirmed(): void
    {
        if ($this->confirmingDeleteId) {
            $company = Company::findOrFail($this->confirmingDeleteId);
            $company->delete();
            session()->flash('success', 'Empresa removida com sucesso!');
            $this->confirmingDeleteId = null;
            $this->resetPage();
        }
    }
    // ---------------------------------------------

    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->resetValidation();
    }

    public function getRowsQuery()
    {
        $q = Company::query();

        if (trim($this->search) !== '') {
            // PostgreSQL: ILIKE para case-insensitive
            $q->where('name', 'ilike', '%'.trim($this->search).'%');
        }

        $sortable = ['id','name','created_at','updated_at'];
        $field = in_array($this->sortField, $sortable) ? $this->sortField : 'created_at';
        $dir   = $this->sortDir === 'asc' ? 'asc' : 'desc';

        return $q->orderBy($field, $dir);
    }

    public function render()
    {
        $companies = $this->getRowsQuery()->paginate($this->perPage);

        return view('livewire.companies-table', [
            'companies' => $companies,
        ]);
    }
}
