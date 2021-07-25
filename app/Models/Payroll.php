<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_from_date',
        'payroll_to_date',
        'payroll_description',
        'payroll_status',
        'prepared_by',
        'approved_by',
        'project_id',
    ];

    public function userApprovedBy() {
        return $this->belongsTo(User::class,'approved_by','id');
    }
    public function userPreparedBy() {
        return $this->belongsTo(User::class,'prepared_by','id');
    }
    public function projects() {
        return $this->belongsTo(Project::class,'project_id','id');
    }
}
