<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Changelog extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['project_id', 'deploy_date', 'user_id', 'version', 'status', 'backlog_id'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function backlog()
    {
        return $this->belongsTo(Backlog::class);
    }
}
