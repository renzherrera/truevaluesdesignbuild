<?php

namespace App\Http\Livewire\Admin\Payroll;

use App\Models\Attendance;
use App\Models\CashAdvance;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;
class ListPayroll extends Component
{
    public $payroll_from_date ,$payroll_to_date,$payroll_description,$total_pay,$payroll_status,
    $createMode = true, $updateMode= false,$summaryMode = false, $selected_id,$searchTerm,$prepared_by,$approved_by,$approved_role,$prepared_role
   ;
    use WithPagination;
    public function render()
    {

        $payrollSummaries = null;
        $cash_adv = null;
        $holidays = null;
        if($this->summaryMode){
        
        //IF TIME_IN IS NOT BLANK AND TIME_OUT IS BLANK = HALF DAY OR 4 HOURS
         //IF TOTAL REGULAR HOURS PER DAY IS GREATER THAN 4 (HALFDAY), THEN TOTAL HOURS LESS 1 HOUR FOR BREAK
          //IF OVERTIME HAS TIME_IN AND TIME_OUT THEN TOTAL HOURS
           //IF OVERTIME HAS TIME_IN AND TIME_OUT IS BLANK THEN THE OVERTIME IS VOIDED OR 0
            //IF POSITION HAS_HOLIDAY = TRUE THEN EMPLOYEE WILL HAVE HOLIDAY PAY
        $holidays = Holiday::where('date','>=',$this->payroll_from_date)->where('date','<=',$this->payroll_to_date)->count();
       
        $cash_adv = CashAdvance::whereBetween('requested_date',[$this->payroll_from_date,$this->payroll_to_date])->where('status','!=','paid')->get();
        $first_in = 'CASE WHEN TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")  )  ) > 4 then
        
        TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")  )  ) -1 ELSE

        TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")  )  ) END
        ';
        $overtime_in = 'TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.second_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.second_offDuty),CONCAT(attendances.attendance_date," ",second_offDuty)   )  )';
        $regular_salary_holiday = '(positions.salary_rate *
        CASE WHEN positions.has_holiday = true then
        (CASE WHEN attendances.attendance_date = holidays.date THEN holidays.rate ELSE 1 END) ELSE 1 END /8)';
        $overtime_salary_holiday = '(positions.salary_rate * 
        CASE WHEN positions.has_holiday = true then
        (CASE WHEN attendances.attendance_date = holidays.date THEN holidays.ot_rate ELSE 1 END)ELSE 1 END /8)';

        $payrollSummaries = Employee::selectRaw('employees.*,positions.salary_rate,ROUND(SUM('.$first_in.')) AS total_regular_hours,

         SUM(ROUND('.$first_in.' *  '.$regular_salary_holiday.'  
         )) AS total_salarypay_with_tax,
         SUM(ROUND(('.$first_in.')  * '.$regular_salary_holiday.' - (('.$first_in.')*(positions.salary_rate))/8       )) AS regularholiday_pay,
         SUM(ROUND(('.$first_in.' )  * (positions.salary_rate * 1 /8) )) AS total_regular_pay,


         SUM(ROUND( '.$overtime_in.' )) AS total_overtime_hours,
         SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' )) AS total_overtimepay_with_tax,
         SUM(ROUND(('.$overtime_in.' )  * (positions.salary_rate * 1 /8) )) AS total_overtime_pay,
         SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' - (('.$overtime_in.' )*(positions.salary_rate))/8       )) AS overtimeholiday_pay
         
         ')
         
        ->whereBetween('attendances.attendance_date',[$this->payroll_from_date,$this->payroll_to_date])
        ->leftJoin('attendances', 'attendances.biometric_id', '=', 'employees.biometric_id')
        ->leftJoin('holidays', 'holidays.date', '=', 'attendances.attendance_date')
        // ->leftJoin('cash_advances', 'cash_advances.employee_id', '=', 'employees.id')
        ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        ->groupBy('employees.id')
        ->paginate(5);
            




        }


        $searchTerm=$this->searchTerm;
        $payrolls = Payroll::orderBy('id','desc')
        ->orWhere('id', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_description', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_from_date', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_to_date', 'LIKE', "%{$searchTerm}%")
        ->paginate(5);
        return view('livewire.admin.payroll.list-payroll', compact('payrolls','payrollSummaries','cash_adv','holidays'))->layout('layouts.master');
    }
    public function updatingSearchTerm(): void
    {
        $this->gotoPage(1);
    }

    public function store() {
        $auth_user = Auth::user()->id;

        $this->validate([
            'payroll_from_date' => 'required|date',
            'payroll_to_date' => 'required|date',      
            'payroll_description' => 'required',
           
        ]); 


         Payroll::create([
            'payroll_from_date' => $this->payroll_from_date,
            'payroll_to_date' => $this->payroll_to_date,
            'payroll_description' => $this->payroll_description,
            'prepared_by' => $auth_user,
            'payroll_status' => "pending",
        ]);
        $this->resetInputFields();
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Payroll Added",
        ]);


    }


    public function listMode() {
        $this->createMode = true;
        $this->updateMode = false;
        $this->summaryMode = false;
        $this->resetInputFields();
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


        $payroll = Payroll::with('user')->findOrFail($id);
        $this->selected_id = $id;
        $this->payroll_from_date = $payroll->payroll_from_date;
        $this->payroll_to_date = $payroll->payroll_to_date;
        $this->payroll_description = $payroll->payroll_description;
        $this->payroll_status = $payroll->payroll_status;
        $this->prepared_by = $payroll->prepared_by;
        $this->approved_by = $payroll->approved_by;
        $preparedBy = User::findOrFail($this->prepared_by);
        $this->prepared_role = $preparedBy->role;
        $this->prepared_by = $preparedBy->name;

        if($payroll->approved_by){
        $approvedBy = User::findOrFail($this->approved_by);
        $this->approved_by = $approvedBy->name;
        $this->approved_role = $preparedBy->role;
       } else{
        $this->approved_by = '';
        $this->approved_role = '';
       }



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

    public function bulkPayslipPDF()
    {   
        // $payroll_to_date = Carbon::parse($this->payroll_to_date)->format('F d, Y');

        $payroll_from_date =  $this->payroll_from_date;
        $payroll_to_date = $this->payroll_to_date;
       
        $holidays = Holiday::where('date','>=',$this->payroll_from_date)->where('date','<=',$this->payroll_to_date)->count();
        $cash_adv = CashAdvance::whereBetween('requested_date',[$this->payroll_from_date,$this->payroll_to_date])->where('status','!=','paid')->get();
        $first_in = 'CASE WHEN TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")  )  ) > 4 then
        
        TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")  )  ) -1 ELSE

        TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),CONCAT(attendances.attendance_date," ","12:00:00")  )  ) END
        ';
        $overtime_in = 'TIMESTAMPDIFF(HOUR, CONCAT(attendances.attendance_date," ",attendances.second_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.second_offDuty),CONCAT(attendances.attendance_date," ",second_offDuty)   )  )';
        $regular_salary_holiday = '(positions.salary_rate *
        CASE WHEN positions.has_holiday = true then
        (CASE WHEN attendances.attendance_date = holidays.date THEN holidays.rate ELSE 1 END) ELSE 1 END /8)';
        $overtime_salary_holiday = '(positions.salary_rate * 
        CASE WHEN positions.has_holiday = true then
        (CASE WHEN attendances.attendance_date = holidays.date THEN holidays.ot_rate ELSE 1 END)ELSE 1 END /8)';

        $payrollSummaries = Employee::with('project')->selectRaw('employees.*,positions.salary_rate,positions.position_title,ROUND(SUM('.$first_in.')) AS total_regular_hours,

         SUM(ROUND('.$first_in.' *  '.$regular_salary_holiday.'  
         )) AS total_salarypay_with_tax,
         SUM(ROUND(('.$first_in.')  * '.$regular_salary_holiday.' - (('.$first_in.')*(positions.salary_rate))/8       )) AS regularholiday_pay,
         SUM(ROUND(('.$first_in.' )  * (positions.salary_rate * 1 /8) )) AS total_regular_pay,


         SUM(ROUND( '.$overtime_in.' )) AS total_overtime_hours,
         SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' )) AS total_overtimepay_with_tax,
         SUM(ROUND(('.$overtime_in.' )  * (positions.salary_rate * 1 /8) )) AS total_overtime_pay,
         SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' - (('.$overtime_in.' )*(positions.salary_rate))/8       )) AS overtimeholiday_pay
         
         ')
       
         
        ->whereBetween('attendances.attendance_date',[$this->payroll_from_date,$this->payroll_to_date])
        ->leftJoin('attendances', 'attendances.biometric_id', '=', 'employees.biometric_id')
        ->leftJoin('holidays', 'holidays.date', '=', 'attendances.attendance_date')
        // ->leftJoin('cash_advances', 'cash_advances.employee_id', '=', 'employees.id')
        ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        ->groupBy('employees.id')
        ->get();


        // $projects = Project::join('project_images','projects.id','=','project_images.project_id');
        view()->share('payrollSummaries',$payrollSummaries);
        
        $pdf = PDF::loadView('livewire.admin.payroll.all-payslip', compact('payrollSummaries','payroll_from_date','payroll_to_date','holidays'))->setPaper('a4')
        ->setOption('margin-left','15')
                        ->setOption('margin-right','15')
                        ->setOption('margin-top','10')
                        ->setOption('margin-bottom','20')
                        ->setOption('footer-center','')
                        ->setOption('footer-left','');
    //    $pdf->setOption('header-html', view('pdf.pdf-header'));
        return $pdf->stream('payslip.pdf');
    }


}
