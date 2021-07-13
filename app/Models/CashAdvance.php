<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashAdvance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'cash_amount',
        'status',
        'requested_date',
        'approved_by',
    ];

    public function employees() {
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}
