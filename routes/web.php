<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CompanyController, ProjectController, ProjectUserController, BacklogController, ChangelogController, ReminderController};

Route::get('/', fn() => redirect()->route('projects.index'));
Route::get('/dashboard', fn() => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('projects', ProjectController::class);
    // Gerenciar usuários do projeto
    Route::get('/projects/{project}/users', [ProjectUserController::class, 'manage'])->name('projects.users.manage');
    Route::post('/projects/{project}/users/{user}', [ProjectUserController::class, 'attach'])->name('projects.users.attach');
    Route::delete('/projects/{project}/users/{user}', [ProjectUserController::class, 'detach'])->name('projects.users.detach');
    // Backlogs (nested)
    Route::get('/projects/{project}/backlogs/create', [BacklogController::class, 'create'])->name('projects.backlogs.create');
    Route::post('/projects/{project}/backlogs', [BacklogController::class, 'store'])->name('projects.backlogs.store');
    Route::get('/projects/{project}/backlogs/{backlog}/edit', [BacklogController::class, 'edit'])->name('projects.backlogs.edit');
    Route::put('/projects/{project}/backlogs/{backlog}', [BacklogController::class, 'update'])->name('projects.backlogs.update');
    Route::delete('/projects/{project}/backlogs/{backlog}', [BacklogController::class, 'destroy'])->name('projects.backlogs.destroy');
    // Changelogs (nested)
    Route::get('/projects/{project}/changelogs/create', [ChangelogController::class, 'create'])->name('projects.changelogs.create');
    Route::post('/projects/{project}/changelogs', [ChangelogController::class, 'store'])->name('projects.changelogs.store');
    Route::get('/projects/{project}/changelogs/{changelog}/edit', [ChangelogController::class, 'edit'])->name('projects.changelogs.edit');
    Route::put('/projects/{project}/changelogs/{changelog}', [ChangelogController::class, 'update'])->name('projects.changelogs.update');
    Route::delete('/projects/{project}/changelogs/{changelog}', [ChangelogController::class, 'destroy'])->name('projects.changelogs.destroy');
    // Reminders (nested)
    Route::get('/projects/{project}/reminders/create', [ReminderController::class, 'create'])->name('projects.reminders.create');
    Route::post('/projects/{project}/reminders', [ReminderController::class, 'store'])->name('projects.reminders.store');
    Route::delete('/projects/{project}/reminders/{reminder}', [ReminderController::class, 'destroy'])->name('projects.reminders.destroy');
});
require __DIR__ . '/auth.php';
