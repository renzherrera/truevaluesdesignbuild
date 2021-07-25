<?php

namespace App\Http\Livewire\Admin\Payroll;

use App\Models\Attendance;
use App\Models\CashAdvance;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\PayrollSummary;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;
class ListPayroll extends Component
{
    public $payroll_from_date ,$payroll_to_date,$payroll_description,$total_pay,$payroll_status,
    $createMode = true, $updateMode= false,$summaryMode = false,$listMode = true,$previewMode, $selected_id,$searchTerm,$prepared_by,$approved_by,$approved_role,$prepared_role,
    $start = null,$end = null, $project_id;
    use WithPagination;
    public function render()
    {
        $cash_adv = null;
        $holidays = null;
        $searchTerm=$this->searchTerm;
        $start = Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        $projects = Project::select('id','project_name')->get();
        $payrolls = Payroll::orderBy('id','desc');
        if($searchTerm){
        $payrolls = $payrolls
        ->orWhere('id', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_description', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_from_date', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_to_date', 'LIKE', "%{$searchTerm}%");
        }
        if($this->start && $this->end){
            $payrolls = $payrolls
            ->whereBetween('payroll_from_date',[$start,$end]);
        }
        $payrolls = $payrolls->paginate(5);
        return view('livewire.admin.payroll.list-payroll', compact('payrolls','cash_adv','holidays','projects'))->layout('layouts.master');
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
       $insertPayroll = Payroll::create([
            'payroll_from_date' => $this->payroll_from_date,
            'payroll_to_date' => $this->payroll_to_date,
            'payroll_description' => $this->payroll_description,
            'prepared_by' => $auth_user,
            'payroll_status' => "pending",
            'project_id' => $this->project_id,
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
        $this->listMode = true;

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
        $this->project_id = $payroll->project_id;

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
            'project_id' => $this->project_id,
        ]);
        $this->updateMode = false;
        $this->createMode = true;


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
        $this->listMode = true;
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function approved($id)
    {   
        // $payroll_to_date = Carbon::parse($this->payroll_to_date)->format('F d, Y');

        try {
        $payroll = Payroll::find($id);
        $payroll_from_date =  $payroll->payroll_from_date;
        $payroll_to_date = $payroll->payroll_to_date;
       //GET FIRST TIME_IN OR FIRST SHIFT IN // IF TIMEDIFF HOURS IS GREATER THAN 4 HOURS THEN LESS 1 HOUR 
       $firstInTimeDiff = 'TIMESTAMPDIFF(minute, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
       IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),IFNULL(CONCAT(attendances.attendance_date," ",second_onDuty),CONCAT(attendances.attendance_date," ","12:00:00" ))  )  )/60';
       $first_in = 'CASE WHEN '.$firstInTimeDiff.' >= 8 then 8 WHEN '.$firstInTimeDiff.' > 4 THEN '.$firstInTimeDiff.' -1 ELSE '.$firstInTimeDiff.'  END';
       //GET OVERTIME DIFF
       $overtime_in = 'TIMESTAMPDIFF(minute, CONCAT(attendances.attendance_date," ",attendances.second_onDuty),
       IFNULL(CONCAT(attendances.attendance_date," ",attendances.second_offDuty),CONCAT(attendances.attendance_date," ",second_offDuty)   )  )/60';

       $regular_salary_holiday = '(positions.salary_rate *
           CASE WHEN positions.has_holiday = true then
           (CASE WHEN attendances.attendance_date = holidays.date THEN holidays.rate ELSE 1 END) ELSE 1 END /8)';
       $overtime_salary_holiday = '(positions.salary_rate * 
           CASE WHEN positions.has_holiday = true then
           (CASE WHEN attendances.attendance_date = holidays.date THEN holidays.ot_rate ELSE 1 END)ELSE 1 END /8)';
        $payrollSummaries = Employee::with('project','cashadvances','attendances')->selectRaw('employees.*,positions.salary_rate,positions.position_title,ROUND(SUM('.$first_in.')) AS total_regular_hours,

         SUM(ROUND('.$first_in.' *  '.$regular_salary_holiday.'  
         )) AS total_salarypay_with_tax,
         SUM(ROUND(('.$first_in.')  * '.$regular_salary_holiday.' - (('.$first_in.')*(positions.salary_rate))/8       )) AS regularholiday_pay,
         
         SUM(ROUND(('.$first_in.' )  * (positions.salary_rate * 1 /8) )) AS total_regular_pay,
         SUM(ROUND( '.$overtime_in.' )) AS total_overtime_hours,
         SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' )) AS total_overtimepay_with_tax,
         SUM(ROUND(('.$overtime_in.' )  * (positions.salary_rate * 1 /8) )) AS total_overtime_pay,
         SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' - (('.$overtime_in.' )*(positions.salary_rate))/8       )) AS overtimeholiday_pay
         
         ')
       
         
        ->whereBetween('attendances.attendance_date',[$payroll_from_date,$payroll_to_date])
        ->leftJoin('attendances', 'attendances.biometric_id', '=', 'employees.biometric_id')
        ->leftJoin('holidays', 'holidays.date', '=', 'attendances.attendance_date')
        ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        ->groupBy('employees.id')
        ->get();


        //check if payroll has records

        
    // INSERT ALL ROWS IN THE LOOP IN THE PAYROLL_SUMMARY TABLE
    if($payroll->payroll_status != "approved" && $payroll->payroll_status != null){

        foreach($payrollSummaries as $payrollSummary){

            $totalRegularHours = $payrollSummary->total_regular_hours;
            $totalOvertime = $payrollSummary->total_overtime_hours;
            if($totalOvertime == null){
                $totalOvertime = 0;
            }
            $totalHolidayPay = $payrollSummary->regularholiday_pay + $payrollSummary->overtimeholiday_pay;
            $payGross = $payrollSummary->total_regular_pay + $payrollSummary->total_overtime_pay + $totalHolidayPay;
            $cashAdvance = $payrollSummary->cashadvances
            ->where('requested_date','>=',$payroll_from_date)
            ->where('requested_date','<=', $payroll_to_date)
            ->where('status','!=','paid')
            ->sum('cash_amount');
            $totalPay = $payGross - $cashAdvance;

            // insert into payroll_summary table
            PayrollSummary::create([
                'payroll_id' => $id,
                'biometric_id' => $payrollSummary->biometric_id,
                'employee_id' => $payrollSummary->id,
                'employee_name' => $payrollSummary->first_name . ' ' . $payrollSummary->middle_name . ' ' . $payrollSummary->last_name,
                'position_title' => $payrollSummary->position_title,
                'project_designated' => $payrollSummary->project->project_name,
                'schedule' => Carbon::parse($payroll_from_date)->format('F d, Y').' - '.Carbon::parse($payroll_to_date)->format('F d, Y'),
                'salary_rate' => $payrollSummary->salary_rate,
                'total_hours_regular' => $totalRegularHours,
                'total_hours_overtime' => $totalOvertime,
                'total_holidaypay' => $totalHolidayPay,
                'salary_gross' => $payGross,
                'cash_advance' => $cashAdvance,
                'total_net_pay' => $totalPay,
            ]);

            //get cashadvance where requested_date where between the payroll date and employees that are in the list
            //update

           $ca = $payrollSummary->cashadvances->where('status','=','approved')->whereBetween('requested_date',[$payroll_from_date,$payroll_to_date]);
           foreach($ca as $c){
               $c->status = "paid";
               $c->save();

           }

           

         }
         $attendances = Attendance::has('employees')->where('attendance_status','=','unpaid')->whereBetween('attendance_date',[$payroll_from_date,$payroll_to_date])->get();
           foreach($attendances as $attendance){
               $attendance->attendance_status = "paid";
               $attendance->save();

           }
         if(!$payroll->approved_by && Auth::user()->role == "superadmin")
         {

            $payroll->update([
                'approved_by' => Auth::user()->id,
                'payroll_status' => 'approved',
            ]);
            $this->payroll_status = $payroll->payroll_status;
            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => 'Success!!',
                'text'  => "Payroll successfully approved and now ready to print.",
            ]);
         
         }
        }// end of if payroll status != printed

        



      

        }catch(Exception $ex){
            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Error!!',
                'text'  => "Submition for payroll failed {$ex->getMessage()}",
            ]);
        }

    }

    public function bulkPayslipPDF($id)
    {   
        // $payroll_to_date = Carbon::parse($this->payroll_to_date)->format('F d, Y');
        // $payroll_from_date = Carbon::parse($this->payroll_from_date)->format('F d, Y');
        $payrolls = Payroll::find($id);
        if($payrolls->payroll_status != "pending"){

        try {
        $printedPayrolls = PayrollSummary::where('payroll_id',$id)->get();

           
        $this->payroll_from_date = $payrolls->payroll_from_date;
        $this->payroll_to_date = $payrolls->payroll_to_date;
    
        $holidays = Holiday::where('date','>=',$this->payroll_from_date)->where('date','<=',$this->payroll_to_date)->count();
      
        view()->share('printedPayrolls',$printedPayrolls);
        
        $pdf = PDF::loadView('livewire.admin.payroll.all-payslip', compact('printedPayrolls','payrolls','holidays'))->setPaper('a4')
        ->setOption('margin-left','15')
                        ->setOption('margin-right','15')
                        ->setOption('margin-top','10')
                        ->setOption('margin-bottom','20')
                        ->setOption('footer-center','')
                        ->setOption('footer-left','');
        $payrolls->update([
            'payroll_status' => 'printed',
        ]);
       
    // session()->flash('message','Order deleted successfully!');
  
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Payroll successfully created.",
        ],
        );

    return $pdf->stream('payslip.pdf') ;


        }catch(Exception $ex){
            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Error!!',
                'text'  => "Printing payroll failed {$ex->getMessage()}",
            ]);
        }

       

    } else {
        $this->emit('swal:modal', [
            'icon'  => 'error',
            'title' => 'Error!!',
            'text'  => "Approval for this payroll is needed.",
        ]);
    }

    }  
}
