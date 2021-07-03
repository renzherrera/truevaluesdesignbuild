<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'project_owner',
        'project_type',
        'project_started',
        'project_ended',
        'project_location',
        'project_status',
        'project_description',
        'estimated_budget'

    ];

    public function projectService(){
        return $this->hasMany(ProjectService::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class);
    }
}
