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
     $updateMode= false,$summaryMode = false,$listMode = true,$previewMode, $selected_id,$searchTerm,$prepared_by,$approved_by,$approved_role,$prepared_role,
    $start = null,$end = null, $project_id=0,$filter_project, $date_start_range,$date_end_range,$allMode = true, $approvedMode = false, $pendingMode = false;
    use WithPagination;
  
    public function hydrate()
    {
        $this->resetValidation();
    }
    public function render()
    {
        $cash_adv = null;
        $holidays = null;
        $searchTerm=$this->searchTerm;
        $start = Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        $projects = Project::select('id','project_name')->get();
        $payrollCounts = $this->getPayrolls()->count();
        if($this->pendingMode){
            $payrolls = $this->pendingPayrolls();
        }elseif($this->approvedMode){
            $payrolls = $this->approvedPayrolls();

        }else{
            $payrolls = $this->getPayrolls()->paginate(5);

        }

        $approvedCounts = $this->getApprovedCounts();
        $pendingCounts = $this->getPendingCounts();
        $totalSalary = $this->getTotalSalary();
        return view('livewire.admin.payroll.list-payroll', compact('payrolls','cash_adv','holidays','projects','approvedCounts','pendingCounts','totalSalary','payrollCounts'))->layout('layouts.master');
    }
    public function updatingSearchTerm(): void
    {
        $this->gotoPage(1);
    }

    public function store() {
        if(!$this->project_id){
            $this->project_id = 0;
        }
        $auth_user = Auth::user()->id;
        $date_start_range = Carbon::parse($this->date_start_range)->toDateTimeString();
        $date_end_range = Carbon::parse($this->date_end_range)->toDateTimeString();
        $this->validate([
            'date_start_range' => 'required|date',
            'date_end_range' => 'required|date',      
            'payroll_description' => 'required',
           
        ]); 
       $insertPayroll = Payroll::create([
            'payroll_from_date' => $date_start_range,
            'payroll_to_date' => $date_end_range,
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
        $this->date_start_range='';
        $this->date_end_range='';
        $this->payroll_description='';
        $this->project_id ='';
        $this->message ='';
    }

    public function edit($id)
    {
        
        $this->updateMode = true;
        $this->summaryMode = false;

        $payroll = Payroll::findOrFail($id);
        $this->selected_id = $id;
        $this->date_start_range = $payroll->payroll_from_date;
        $this->date_end_range = $payroll->payroll_to_date;
        $this->payroll_description = $payroll->payroll_description;
        $this->project_id = $payroll->project_id;

    }

    
    
    public function update() {
        $this->validate([
            'date_start_range' => 'required|date',
            'date_end_range' => 'required|date',      
            'payroll_description' => 'required',
           
        ]); 
        
    if ($this->selected_id) {
        $payroll = Payroll::find($this->selected_id);
        $payroll->update([
            'payroll_from_date' => $this->date_start_range,
            'payroll_to_date' => $this->date_end_range,
            'payroll_description' => $this->payroll_description,
            'project_id' => $this->project_id,
        ]);


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Payroll with ID: {$this->selected_id} successfully updated",
        ]);

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
        $payrollSummaries = Employee::with('project','cashadvances','attendances','schedule')->selectRaw('employees.*,positions.salary_rate,positions.position_title,ROUND(SUM('.$first_in.')) AS total_regular_hours,

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
        ->where('attendances.attendance_status','=','unpaid')
        ->leftJoin('attendances', 'attendances.biometric_id', '=', 'employees.biometric_id')
        ->leftJoin('holidays', 'holidays.date', '=', 'attendances.attendance_date')
        ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        ->groupBy('employees.id')
        ->get();
        //check if payroll has records
        
    // INSERT ALL ROWS IN THE LOOP IN THE PAYROLL_SUMMARY TABLE
        if($payroll->payroll_status != "approved" && $payroll->payroll_status != null && $payrollSummaries->count() > 0 ){

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
                if($totalPay >= 0){
                PayrollSummary::create([
                    'payroll_id' => $id,
                    'biometric_id' => $payrollSummary->biometric_id,
                    'employee_id' => $payrollSummary->id,
                    'employee_name' => $payrollSummary->first_name . ' ' . $payrollSummary->middle_name . ' ' . $payrollSummary->last_name,
                    'position_title' => $payrollSummary->position_title,
                    'project_id' => $payrollSummary->project_id,
                    // 'schedule' => Carbon::parse($payroll_from_date)->format('F d, Y').' - '.Carbon::parse($payroll_to_date)->format('F d, Y'),
                    'payroll_from_date' => $payroll_from_date,
                    'payroll_to_date' => $payroll_to_date,
                    'schedule_in'=> $payrollSummary->schedule->start_time,
                    'schedule_out'=> $payrollSummary->schedule->end_time,
                    'salary_rate' => $payrollSummary->salary_rate,
                    'total_hours_regular' => $totalRegularHours,
                    'total_hours_overtime' => $totalOvertime,
                    'total_holidaypay' => $totalHolidayPay,
                    'salary_gross' => $payGross,
                    'cash_advance' => $cashAdvance,
                    'total_net_pay' => $totalPay,
                ]);
            }
                //get cashadvance where requested_date where between the payroll date and employees that are in the list
                //update


            

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
            else {
                $this->emit('swal:modal', [
                    'icon'  => 'error',
                    'title' => 'Error!!',
                    'text'  => "No Records found!",
                ]);
            }


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
        if($payrolls->approved_by != null){
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
        // $payrolls->update([
        //     'payroll_status' => 'printed',
        // ]);
       
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
    function getApprovedCounts() {
       
       return $payrolls = $this->getPayrolls()->where('approved_by','!=', null)->count();
    }

    function getPendingCounts() {
       
       return  $this->getPayrolls()->where('approved_by','=', null)->where('prepared_by','!=',null)->where('payroll_status','pending')->count();

    }

    function getTotalSalary() {
        $payrollSalary = PayrollSummary::select('total_net_pay','project_id','payroll_from_date','payroll_to_date')->get();
        if($this->start && $this->end){
            $payrollSalary = $payrollSalary
            ->whereBetween('payroll_from_date',[$this->start,$this->end]);
            // ->orWhereBetween('payroll_to_date',[$this->start,$this->end]);
        }
            if($this->filter_project !=0){
            $payrollSalary = $payrollSalary->where('project_id','=',$this->filter_project);
              }
        return $payrollSalary->sum('total_net_pay');
    }

    function getPayrolls(){
        $start = Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        $searchTerm = $this->searchTerm;
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
        if($this->filter_project){
            $payrolls = $payrolls->where('project_id',$this->filter_project);
        }

       return $payrolls = $payrolls;

    }
    function allPayrolls() {
        $this->allMode = true;
        $this->approvedMode = false;
        $this->pendingMode = false;
        $this->getPayrolls();
       
   
    }

    function approvedPayrolls() {
        $this->allMode = false;
        $this->approvedMode = true;
        $this->pendingMode = false;
       
       return $this->getPayrolls()->where('approved_by','!=',null)->paginate(5);
    }

    function pendingPayrolls() {

        $this->allMode = false;
        $this->approvedMode = false;
        $this->pendingMode = true;
       
       return $this->getPayrolls()->where('payroll_status','pending')->paginate(5);
    }

    public function createPDF()
    {
        $allMode = $this->allMode;
        $approvedMode = $this->approvedMode;
        $pendingMode = $this->pendingMode;
        $cash_adv = null;
        $holidays = null;
        $searchTerm= $this->searchTerm;
        $start = Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        $projects = Project::select('id','project_name')->get();
        $payrollCounts = Payroll::select('id')->count();
        if($this->pendingMode){
            $payrolls = $this->pendingPayrolls();
        }elseif($this->approvedMode){
            $payrolls = $this->approvedPayrolls();
        }else{
            $payrolls = $this->getPayrolls()->get();
        }
        $projectName = null;
        if($this->filter_project){
        $projectName = Project::find($this->filter_project)->select('project_name')->first();
        }
        $date_filter = null;
        if($this->start && $this->end){
            $date_filter = Carbon::parse($this->start)->format('F d, Y'). ' - ' . Carbon::parse($this->end)->format('F d, Y');
        }
        $approvedCounts = $this->getApprovedCounts();
        $pendingCounts = $this->getPendingCounts();
        $totalSalary = $this->getTotalSalary();
        // $projects = Project::join('project_images','projects.id','=','project_images.project_id');
        view()->share('payrolls',$payrolls);
        
        $pdf = PDF::loadView('livewire.admin.payroll.payrolls-pdf',  
        compact('payrolls','cash_adv','holidays','projects','approvedCounts','pendingCounts','totalSalary','payrollCounts','allMode','approvedMode','pendingMode','date_filter','projectName'))
        ->setPaper('a4')->setOrientation('landscape');
       $pdf->setOption('header-html', view('pdf.pdf-header'));
       if($payrolls){
        return $pdf->stream('attendance.pdf');
    }
    }

    function markPaid($id) {
        try{

            $payroll = Payroll::find($id);
            $payroll_from_date =  $payroll->payroll_from_date;
            $payroll_to_date = $payroll->payroll_to_date;
            $payrollSummaries = PayrollSummary::has('employees')->where('payroll_id',$id)->whereBetween('payroll_from_date',[$payroll_from_date,$payroll_to_date])->get();
            foreach($payrollSummaries as $payrollSummary){
        

              
            //     // insert into payroll_summary table
            // $ca = $payrollSummary->cashadvances->where('status','=','approved')->whereBetween('requested_date',[$payroll_from_date,$payroll_to_date]);

            //  foreach($ca as $c){
            //      $c->status = "paid";
            //      $c->save();
    
            //  }
            
                $attendances = $payrollSummary->employees->attendances;
                   $attendances->attendance_status = "paid";
                   $attendances->save();

            $cashadvances = $payrollSummary->employees->cashadvances->where('status','=','approved');
               foreach($cashadvances as $ca){
                  $ca->status = "paid";
                  $ca->save();
    
              }
    
        }

            if($payroll->payroll_status =="approved"){
                $payroll->payroll_status = "paid";
                $payroll->save();
            }

            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => 'Success!!',
                'text'  => "Payroll successfully marked as Paid",
            ]);
        }catch(Exception $ex){
              $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'error!!',
                'text'  => "Marking as Paid failed! {$ex->getMessage()}",
            ]);
        }
      
    }

    function withrawPayroll($id) {
        try{
        $payroll = Payroll::find($id);
        $payrollSummary = PayrollSummary::where('payroll_id',$id);
        $payrollSummary->delete();
        $payroll_from_date =  $payroll->payroll_from_date;
        $payroll_to_date = $payroll->payroll_to_date;
             $payroll->payroll_status = "pending";
             $payroll->approved_by = null;
             $payroll->save();

            //  $payrolLSummaries = Employee::has('cashadvances')->get();
            //  foreach($payrolLSummaries as $payrollSummary){
            //  $ca = $payrollSummary->cashadvances->where('status','=','approved')->whereBetween('requested_date',[$payroll_from_date,$payroll_to_date]);
            //   foreach($ca as $c){
            //       $c->status = "approved";
            //       $c->save();
            //   }
            //  }
     
              $attendances = Attendance::has('employees')->where('attendance_status','=','approved')->whereBetween('attendance_date',[$payroll_from_date,$payroll_to_date])->get();
                foreach($attendances as $attendance){
                    $attendance->attendance_status = "unpaid";
                    $attendance->save();
     
                }
 

                $this->emit('swal:modal', [
                    'icon'  => 'success',
                    'title' => 'Success!!',
                    'text'  => "Approval for the payroll successfully withrawed!",
                ]);
            } catch(Exception $ex){
                
                $this->emit('swal:modal', [
                    'icon'  => 'error',
                    'title' => 'Error!!',
                    'text'  => "Withdrawal of approval failed!",
                ]);
            }

    }

    function revertPayroll($id) {
        try{
        $payroll = Payroll::find($id);
        $payroll_from_date =  $payroll->payroll_from_date;
        $payroll_to_date = $payroll->payroll_to_date;
        if($payroll->payroll_status == "paid"){
             $payroll->payroll_status = "approved";
             $payroll->save();
             $payrolLSummaries = Employee::has('cashadvances')->get();
             foreach($payrolLSummaries as $payrollSummary){
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
             if($totalPay >= 0){
             $ca = $payrollSummary->cashadvances->where('status','=','paid')->whereBetween('requested_date',[$payroll_from_date,$payroll_to_date]);
              foreach($ca as $c){
                  $c->status = "approved";
                  $c->save();
              }
             
             }
            } // end of foreach
     
            $attendances = Attendance::has('employees')->where('attendance_status','=','paid')->whereBetween('attendance_date',[$payroll_from_date,$payroll_to_date])->get();
            foreach($attendances as $attendance){
                $attendance->attendance_status = "unpaid";
                $attendance->save();
 
            }
            } //end if payroll status
 

                $this->emit('swal:modal', [
                    'icon'  => 'success',
                    'title' => 'Success!!',
                    'text'  => "Payroll successfully reverted!",
                ]);
            } catch(Exception $ex){
                
                $this->emit('swal:modal', [
                    'icon'  => 'error',
                    'title' => 'Error!!',
                    'text'  => "Revert to approval failed!",
                ]);
            }

    }
}
