<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = "attendances";
    protected $fillable = [
        'biometric_id',
        'attendance_date',
        'first_onDuty',
        'first_offDuty',
        'second_onDuty',
        'second_offDuty',
    ];

    public function employees() {
        return $this->belongsTo(Employee::class,'biometric_id','biometric_id');
    }
}
