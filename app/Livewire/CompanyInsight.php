<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Company;
use App\Models\Backlog;
use App\Models\Changelog;
// Se já existir o model Reminder, descomente a linha abaixo.
// use App\Models\Reminder;

class CompanyInsight extends Component
{
    use WithPagination;

    public Company $company;

    // UI state
    public string $tab = 'backlogs'; // 'backlogs' | 'changelogs' | 'reminders'
    public string $search = '';
    public string $status = 'all'; // filtro de status dos backlogs
    public int $perPage = 10;

    protected $queryString = [
        'tab'     => ['except' => 'backlogs'],
        'search'  => ['except' => ''],
        'status'  => ['except' => 'all'],
        'perPage' => ['except' => 10],
    ];

    public function mount(Company $company)
    {
        $this->company = $company;
    }

    public function updatedSearch()  { $this->resetPage(); }
    public function updatedStatus()  { $this->resetPage(); }
    public function updatedPerPage() { $this->resetPage(); }

    public function switchTab(string $tab): void
    {
        $allowed = ['backlogs','changelogs','reminders'];
        $this->tab = in_array($tab, $allowed) ? $tab : 'backlogs';
        $this->resetPage();
    }

    public function getBacklogsProperty()
    {
        $q = Backlog::with(['project','assignee'])
            ->whereHas('project', fn($p) => $p->where('company_id', $this->company->id))
            ->latest();

        if ($this->search !== '') {
            $term = '%'.trim($this->search).'%';
            $q->where(function($w) use ($term){
                $w->where('task_name','ilike',$term)
                  ->orWhere('description','ilike',$term)
                  ->orWhereHas('project', fn($p) => $p->where('name','ilike',$term));
            });
        }

        if ($this->status !== 'all') {
            $q->where('status', $this->status);
        }

        return $q->paginate($this->perPage);
    }

    public function getChangelogsProperty()
    {
        $q = Changelog::with(['project','user'])
            ->whereHas('project', fn($p) => $p->where('company_id', $this->company->id))
            ->latest();

        if ($this->search !== '') {
            $term = '%'.trim($this->search).'%';
            $q->where(function($w) use ($term){
                $w->where('title','ilike',$term)
                  ->orWhere('description','ilike',$term)
                  ->orWhere('version','ilike',$term)
                  ->orWhereHas('project', fn($p) => $p->where('name','ilike',$term));
            });
        }

        return $q->paginate($this->perPage);
    }

    public function getRemindersProperty()
    {
        // Se você JÁ tem um model Reminder, descomente o bloco abaixo
        /*
        $q = Reminder::with(['project','user'])
            ->whereHas('project', fn($p) => $p->where('company_id', $this->company->id))
            ->latest();

        if ($this->search !== '') {
            $term = '%'.trim($this->search).'%';
            $q->where(function($w) use ($term){
                $w->where('title','ilike',$term)
                  ->orWhere('notes','ilike',$term)
                  ->orWhereHas('project', fn($p) => $p->where('name','ilike',$term));
            });
        }

        return $q->paginate($this->perPage);
        */

        // Caso ainda não tenha o model Reminder, retornamos uma coleção vazia paginável “fake”.
        return collect([]);
    }

    public function render()
    {
        return view('livewire.company-insight', [
            'backlogs'   => $this->tab === 'backlogs'   ? $this->backlogs   : null,
            'changelogs' => $this->tab === 'changelogs' ? $this->changelogs : null,
            'reminders'  => $this->tab === 'reminders'  ? $this->reminders  : null,
        ]);
    }
}
