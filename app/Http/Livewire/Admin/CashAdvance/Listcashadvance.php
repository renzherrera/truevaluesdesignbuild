<?php

namespace App\Http\Livewire\Admin\CashAdvance;

use App\Models\Employee;
use Livewire\Component;

class Listcashadvance extends Component
{
    public $amount_cash, $employee_id;
    public function render()
    {
        //fill combobox employees
        $employees = Employee::select('id','first_name','middle_name','last_name')->get();
        return view('livewire.admin.cash-advance.listcashadvance', compact('employees'))->layout('layouts.master');
    }
}
