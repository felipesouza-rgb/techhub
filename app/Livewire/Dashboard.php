<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;
use App\Models\Project;
use App\Models\Backlog;
use App\Models\Changelog;

class Dashboard extends Component
{
    public array $counts = [];
    public string $search = '';
    public string $status = 'all'; // filtro de status do backlog
    public $recentBacklogs = [];
    public $recentChangelogs = [];

    // Paginação simples “manual” (sem trait, só exemplo)
    public int $limit = 5;

    public function mount()
    {
        $this->loadData();
    }

    public function updated($prop)
    {
        // Quando search/status mudar, recarrega {Anotar no caderno}
        if (in_array($prop, ['search','status'])) {
            $this->loadData();
        }
    }

    public function loadMore()
    {
        $this->limit += 5;
        $this->loadData();
    }

    protected function loadData(): void
    {
        $this->counts = [
            'companies'     => Company::count(),
            'projects'      => Project::count(),
            'backlogs'      => Backlog::count(),
            'done_backlogs' => Backlog::where('status','done')->count(),
            'changelogs'    => Changelog::count(),
        ];

        $backlogQuery = Backlog::with(['project','assignee'])->latest();

        if ($this->search !== '') {
            $backlogQuery->where(function($q){
                $q->where('task_name','ilike', "%{$this->search}%")
                  ->orWhere('description','ilike', "%{$this->search}%");
            });
        }

        if ($this->status !== 'all') {
            $backlogQuery->where('status', $this->status);
        }

        $this->recentBacklogs = $backlogQuery->take($this->limit)->get();

        $changelogQuery = Changelog::with(['project','user'])->latest();
        if ($this->search !== '') {
            $changelogQuery->where(function($q){
                $q->where('title','ilike', "%{$this->search}%")
                  ->orWhere('description','ilike', "%{$this->search}%")
                  ->orWhere('version','ilike', "%{$this->search}%");
            });
        }
        $this->recentChangelogs = $changelogQuery->take($this->limit)->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
