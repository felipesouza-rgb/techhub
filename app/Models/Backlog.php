<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Backlog extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['project_id', 'task_name', 'description', 'type', 'status', 'assigned_to', 'priority'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function changelogs()
    {
        return $this->hasMany(Changelog::class);
    }
}
