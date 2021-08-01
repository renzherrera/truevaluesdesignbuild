<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSummary extends Model
{
    use HasFactory;
    protected $table = "payroll_summary";
    protected $fillable = [
        'payroll_id',
        'employee_id',
        'biometric_id',
        'employee_name',
        'position_title',
        'project_designated',
        'schedule_in',
        'schedule_out',
        'payroll_from_date',
        'payroll_to_date',
        'project_id',
        'salary_rate',
        'total_hours_regular',
        'total_hours_overtime',
        'total_holidaypay',
        'salary_gross',
        'cash_advance',
        'total_net_pay',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function employees() {
        return $this->belongsTo(Employee::class ,'employee_id','id');
    }

    public function projects() {
        return $this->belongsTo(Project::class ,'project_id','id');
    }

    public function payrolls() {
        return $this->belongsTo(Payroll::class,'payroll_id','id');
    }
}
