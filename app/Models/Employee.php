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
        'biometric_id',
        'card_number',

    ];

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function attendances(){
        return $this->belongsTo(Attendance::class,'biometric_id','biometric_id')->orderBy('attendance_date','desc');
    }

    public function cashadvances(){
        return $this->hasMany(CashAdvance::class,'employee_id','id');
    }
}
