<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'contact',
        'date_of_birth',
        'gender',
        'status',
        'position_id',
        'schedule_id',
        'project_id',
        'address',
        'image',

    ];
}
