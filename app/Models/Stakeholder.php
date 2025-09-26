<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    protected $fillable = ['project_id', 'name', 'email', 'role'];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function reminders() {
        return $this->hasMany(Reminder::class);
    }
}
