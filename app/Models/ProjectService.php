<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectService extends Model
{
    use HasFactory;

    protected $fillable = ['service_id','project_id'];

    public function service()
    {     
    return $this->belongsTo(Service::class); 
    }
}
