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
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
