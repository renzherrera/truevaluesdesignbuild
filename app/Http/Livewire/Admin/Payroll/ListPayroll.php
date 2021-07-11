<?php

namespace App\Http\Livewire\Admin\Payroll;

use App\Models\Attendance;
use App\Models\CashAdvance;
use App\Models\Employee;
use App\Models\Payroll;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
class ListPayroll extends Component
{
    public $payroll_from_date ,$payroll_to_date,$payroll_description,$total_pay,$payroll_status,
    $createMode = true, $updateMode= false,$summaryMode = false, $selected_id,$searchTerm,
    $payrollFrom, $payrollTo;
    use WithPagination;
    public function render()
    {

        $payrollSummaries = null;
        $cash_adv = null;
        if($this->summaryMode){
        

        // GET TOTAL WORKING HOURS SUM AND ROUND OFF, IF TIME OUT IS NULL TOTAL HOURS = TIME IN - 12PM
        //IF HAS TIME IN 
       
        // $cash_adv = CashAdvance::whereBetween('requested_date',[$this->payroll_from_date,$this->payroll_to_date])->where('status','!=','paid')->get();
            
        // $payrollSummaries = Employee::select('employees.*','positions.salary_rate',
        // \DB::raw('ROUND(SUM(CASE WHEN TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        // IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")   )  ) > 4 then 
        // TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        // IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")   )   ) - 1
        // END)) AS total_regular_hours'),
        // // GET TOTAL OVERTIME
        // \DB::raw('ROUND(SUM(CASE WHEN TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.second_onDuty),
        // IFNULL(CONCAT(attendances.attendance_date," ",attendances.second_offDuty),CONCAT(attendances.attendance_date," ","24:00:00")   )  ) > 4 then 
        // TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.second_onDuty),
        // IFNULL(CONCAT(attendances.attendance_date," ",attendances.second_offDuty),CONCAT(attendances.attendance_date," ","24:00:00")   )   ) - 1
        // END)) AS total_overtime_hours'),
        
        // \DB::raw('(positions.salary_rate/8) * (ROUND(SUM(CASE WHEN TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.second_onDuty),
        // IFNULL(CONCAT(attendances.attendance_date," ",attendances.second_offDuty),CONCAT(attendances.attendance_date," ","24:00:00")   )  ) > 4 then 
        // TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.second_onDuty),
        // IFNULL(CONCAT(attendances.attendance_date," ",attendances.second_offDuty),CONCAT(attendances.attendance_date," ","24:00:00")   )   ) - 1
        // END)) + ROUND(SUM(CASE WHEN TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        // IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")   )  ) > 4 then 
        // TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        // IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")   )   ) - 1
        // END) )) as all_salaries'),
        
            
        // )->whereBetween('attendances.attendance_date',[$this->payroll_from_date,$this->payroll_to_date])
        // ->leftJoin('attendances', 'attendances.biometric_id', '=', 'employees.biometric_id')
        // // ->leftJoin('cash_advances', 'cash_advances.employee_id', '=', 'employees.id')
        // ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        // ->groupBy('employees.id')
        // ->paginate(5);
        $cash_adv = CashAdvance::whereBetween('requested_date',[$this->payroll_from_date,$this->payroll_to_date])->where('status','!=','paid')->get();
        $first_in = ' TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")  )  )';
        $overtime_in = 'TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.second_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.second_offDuty),CONCAT(attendances.attendance_date," ",second_offDuty)   )  )';
        $overtime_salary_holiday = '(positions.salary_rate * 
        CASE WHEN positions.has_holiday = true then
        (CASE WHEN attendances.attendance_date = holidays.date THEN holidays.ot_rate ELSE 1 END)ELSE 1 END /8)';


        $payrollSummaries = Employee::selectRaw('employees.*,positions.salary_rate,ROUND(SUM(CASE WHEN '.$first_in.'  > 4 then 
         '.$first_in.' - 1 END)) AS total_regular_hours,

         SUM(ROUND(CASE WHEN '.$first_in.' > 4 then 
         ('.$first_in.'- 1)  * (positions.salary_rate *
         CASE WHEN positions.has_holiday = true then
         (CASE WHEN attendances.attendance_date = holidays.date THEN holidays.rate ELSE 1 END) ELSE 1 END /8)   
         END)) AS total_salarypay_with_tax, 


         SUM(ROUND( '.$overtime_in.' )) AS total_overtime_hours,

         SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' )) AS total_overtimepay_with_tax
         
         ')
       
         
        ->whereBetween('attendances.attendance_date',[$this->payroll_from_date,$this->payroll_to_date])
        ->leftJoin('attendances', 'attendances.biometric_id', '=', 'employees.biometric_id')
        ->leftJoin('holidays', 'holidays.date', '=', 'attendances.attendance_date')
        // ->leftJoin('cash_advances', 'cash_advances.employee_id', '=', 'employees.id')
        ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        ->groupBy('employees.id')
        ->paginate(5);
            



        dd($payrollSummaries);

        }


        $searchTerm=$this->searchTerm;
        $payrolls = Payroll::orderBy('id','desc')
        ->orWhere('id', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_description', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_from_date', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_to_date', 'LIKE', "%{$searchTerm}%")
        ->paginate(5);
        return view('livewire.admin.payroll.list-payroll', compact('payrolls','payrollSummaries','cash_adv'))->layout('layouts.master');
    }
    public function updatingSearchTerm(): void
    {
        $this->gotoPage(1);
    }

    public function store() {
        $this->validate([
            'payroll_from_date' => 'required|date',
            'payroll_to_date' => 'required|date',      
            'payroll_description' => 'required',
           
        ]); 


         Payroll::create([
            'payroll_from_date' => $this->payroll_from_date,
            'payroll_to_date' => $this->payroll_to_date,
            'payroll_description' => $this->payroll_description,
            'payroll_status' => "Not Printed",
        ]);
        $this->resetInputFields();
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Payroll Added",
        ]);

    }

    public function resetInputFields()
    {
        $this->payroll_from_date='';
        $this->payroll_to_date='';
        $this->payroll_description='';
  
    
    }

    
    public function edit($id)
    {
        $this->createMode = false;
        $this->updateMode = true;
        $this->summaryMode = false;

        $payroll = Payroll::findOrFail($id);
        $this->selected_id = $id;
        $this->payroll_from_date = $payroll->payroll_from_date;
        $this->payroll_to_date = $payroll->payroll_to_date;
        $this->payroll_description = $payroll->payroll_description;

    }

    public function payrollSummary($id)
    {
        $this->createMode = false;
        $this->updateMode = false;
        $this->listMode = false;
        $this->summaryMode = true;

        $payroll = Payroll::findOrFail($id);
        $this->selected_id = $id;
        $this->payroll_from_date = $payroll->payroll_from_date;
        $this->payroll_to_date = $payroll->payroll_to_date;
        $this->payroll_description = $payroll->payroll_description;
        $this->payrollFrom = $this->payroll_from_date;
        $this->payrollTo = $this->payroll_to_date;
        $this->payroll_status = $payroll->payroll_status;

    }
    public function update() {
        $this->validate([
            'payroll_from_date' => 'required|date',
            'payroll_to_date' => 'required|date',      
            'payroll_description' => 'required',
           
        ]); 
        
    if ($this->selected_id) {
        $payroll = Payroll::find($this->selected_id);
        $payroll->update([
            'payroll_from_date' => $this->payroll_from_date,
            'payroll_to_date' => $this->payroll_to_date,
            'payroll_description' => $this->payroll_description,
            'payroll_status' => "Not Printed",
        ]);
        $this->updateMode = false;


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Payroll with ID: {$this->selected_id} successfully updated",
        ]);
        $this->resetInputFields();

    }
    }

    public function destroy(Payroll $payroll) {
        try{
            $concatPayroll = $payroll->payroll_from_date . ' - '. $payroll->payroll_to_date;
            $payroll->delete();
            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => 'Success!!',
                'text'  => "{$concatPayroll} successfully deleted",
            ]);

        }catch(Exception $ex){

            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Error!!',
                'text'  => "Deletion failed. {$ex->getMessage()}",

            ]);
        }
      
    }

    public function createMode() {
        $this->createMode = true;
        $this->updateMode = false;
        $this->resetInputFields();
    }

}
