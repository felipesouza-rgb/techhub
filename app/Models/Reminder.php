<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reminder extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['project_id', 'stakeholder_user_id', 'notification_date'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function stakeholder()
    {
        return $this->belongsTo(User::class, 'stakeholder_user_id');
    }
}
