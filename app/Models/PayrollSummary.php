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
        'employee_name',
        'position_title',
        'project_designated',
        'schedule',
        'salary_rate',
        'total_hours_regular',
        'total_hours_overtime',
        'total_holidaypay',
        'salary_gross',
        'cash_advance',
        'total_net_pay',
    ];
}
