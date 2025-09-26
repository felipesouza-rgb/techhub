<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;
use App\Models\Company;

class ProjectsTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDir = 'desc';
    public int $perPage = 10;

    public ?int $companyFilter = null;

    // Modal create/edit
    public bool $showModal = false;
    public ?int $editingId = null;

    // Campos do form
    public string $name = '';
    public ?string $description = '';
    public ?string $stakeholder_name = '';
    public ?int $company_id = null;

    // Modal de confirmação de delete
    public ?int $confirmingDeleteId = null;

    protected $rules = [
        'name'             => 'required|string|min:2|max:150',
        'description'      => 'nullable|string|max:5000',
        'stakeholder_name' => 'nullable|string|max:150',
        'company_id'       => 'required|integer|exists:companies,id',
    ];

    protected $messages = [
        'name.required'       => 'O nome é obrigatório.',
        'company_id.required' => 'Selecione uma empresa.',
    ];

    // reset paginação ao mudar filtros
    public function updatedSearch()       { $this->resetPage(); }
    public function updatedPerPage()      { $this->resetPage(); }
    public function updatedCompanyFilter(){ $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDir   = 'asc';
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
        $p = Project::findOrFail($id);
        $this->editingId       = $p->id;
        $this->name            = $p->name ?? '';
        $this->description     = (string)($p->description ?? '');
        $this->stakeholder_name= (string)($p->stakeholder_name ?? '');
        $this->company_id      = $p->company_id;
        $this->showModal       = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editingId) {
            $p = Project::findOrFail($this->editingId);
            $p->update([
                'name'             => $this->name,
                'description'      => $this->description,
                'stakeholder_name' => $this->stakeholder_name,
                'company_id'       => $this->company_id,
            ]);
            session()->flash('success', 'Projeto atualizado com sucesso!');
        } else {
            Project::create([
                'name'             => $this->name,
                'description'      => $this->description,
                'stakeholder_name' => $this->stakeholder_name,
                'company_id'       => $this->company_id,
            ]);
            session()->flash('success', 'Projeto criado com sucesso!');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    // ---- confirmação de delete (Livewire puro)
    public function confirmDelete(int $id): void
    {
        $this->confirmingDeleteId = $id;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeleteId = null;
    }

    public function deleteConfirmed(): void
    {
        if ($this->confirmingDeleteId) {
            $p = Project::findOrFail($this->confirmingDeleteId);
            $p->delete();
            session()->flash('success', 'Projeto removido com sucesso!');
            $this->confirmingDeleteId = null;
            $this->resetPage();
        }
    }
    // ----

    protected function resetForm(): void
    {
        $this->editingId        = null;
        $this->name             = '';
        $this->description      = '';
        $this->stakeholder_name = '';
        $this->company_id       = null;
        $this->resetValidation();
    }

    public function getRowsQuery()
    {
        // eager para company (evita N+1)
        $q = Project::query()->with('company');

        if (trim($this->search) !== '') {
            $term = '%'.trim($this->search).'%';
            // PostgreSQL: ILIKE (case-insensitive)
            $q->where(function($w) use ($term) {
                $w->where('name', 'ilike', $term)
                  ->orWhere('description', 'ilike', $term)
                  ->orWhere('stakeholder_name', 'ilike', $term);
            });
        }

        if ($this->companyFilter) {
            $q->where('company_id', $this->companyFilter);
        }

        $sortable = ['id','name','company_id','created_at','updated_at'];
        $field = in_array($this->sortField, $sortable) ? $this->sortField : 'created_at';
        $dir   = $this->sortDir === 'asc' ? 'asc' : 'desc';

        return $q->orderBy($field, $dir);
    }

    public function render()
    {
        $projects = $this->getRowsQuery()->paginate($this->perPage);
        $companies = Company::orderBy('name')->get(['id','name']);

        return view('livewire.projects-table', [
            'projects'  => $projects,
            'companies' => $companies,
        ]);
    }
}
