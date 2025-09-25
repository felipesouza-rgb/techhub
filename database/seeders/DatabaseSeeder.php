<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Company, Project, Backlog, Changelog, Reminder};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $felipe = User::factory()->create(['name' => 'Felipe Souza', 'email' => 'felipe@example.com']);
        $gustavo = User::factory()->create(['name' => 'Gustavo Silva', 'email' => 'gustavo@example.com']);
        $william = User::factory()->create(['name' => 'William Infra', 'email' => 'william@example.com']);
        $marcia = User::factory()->create(['name' => 'Marcia Stake', 'email' => 'marcia@example.com']);
        $comp = Company::create(['name' => 'Tech Company']);
        $proj = Project::create(['name' => 'TechHub', 'description' => 'Backlog/Changelog manager', 'stakeholder_name' => 'Marcia', 'company_id' => $comp->id]);
        $proj->users()->sync([$felipe->id, $gustavo->id, $william->id]);
        $task = Backlog::create(['project_id' => $proj->id, 'task_name' => 'Auth & CRUD', 'type' => 'feature', 'status' => 'in_progress', 'assigned_to' => $felipe->id, 'priority' => 2]);
        Changelog::create(['project_id' => $proj->id, 'version' => '0.1.0', 'status' => 'deploy_pending', 'backlog_id' => $task->id]);
        Reminder::create(['project_id' => $proj->id, 'stakeholder_user_id' => $marcia->id, 'notification_date' => now()->addDay()->toDateString()]);
    }
}
