<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reminder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id', 'stakeholder_id', 'notification_date', 'days_after_deploy',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Se seus stakeholders são usuários internos, troque para User::class
    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class); // ou User::class
    }
}
