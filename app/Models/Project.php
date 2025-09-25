<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'description', 'stakeholder_name', 'company_id'];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_users')->withTimestamps();
    }
    public function backlogs()
    {
        return $this->hasMany(Backlog::class);
    }
    public function changelogs()
    {
        return $this->hasMany(Changelog::class);
    }
    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
