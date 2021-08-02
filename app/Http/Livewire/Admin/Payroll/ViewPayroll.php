<?php

namespace App\Http\Livewire\Admin\Payroll;

use App\Models\Attendance;
use App\Models\CashAdvance;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\PayrollSummary;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class ViewPayroll extends Component
{
    use WithPagination;
    public $selected_payroll,$payroll_description,$payroll_from_date,$payroll_to_date,$project_id,$payroll_status,$prepared_by,
    $prepared_role,$approved_by ,$approved_role,$payroll,$payrolls,$payroll_preview,$cash_adv,$first_in,$overtime_in,
    $overtime_salary_holiday,$regular_salary_holiday,$holidays, $searchTerm,$employee_preview_biometric_id ;

    private $payrollSummaries;

    public function mount(int $payroll) {

        //GET PAYROLL INFORMATION
        $payrolls = Payroll::with('userApprovedBy','userPreparedBy')->find($payroll);
        $this->payroll_description = $payrolls->payroll_description;
        $this->payroll_from_date = $payrolls->payroll_from_date;
        $this->payroll_to_date = $payrolls->payroll_to_date;
        $this->payroll_status = $payrolls->payroll_status;
        $this->project_id = $payrolls->project_id;
        if($payrolls->approved_by){
        $this->approved_by = $payrolls->userApprovedBy->name;
        $this->approved_role = $payrolls->userApprovedBy->role;
        }
        $this->prepared_role = $payrolls->userPreparedBy->role;
        $this->prepared_by = $payrolls->userPreparedBy->name;

        $this->selected_payroll = $payroll;
        $this->payrolls = $payrolls;

        //GET CASHADVANCE TABLE
        $cash_adv = CashAdvance::whereBetween('requested_date',[$this->payroll_from_date,$this->payroll_to_date])->where('status','!=','paid')->get();
        $this->cash_adv = $cash_adv;

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
            $holidays = Holiday::where('date','>=',$this->payroll_from_date)->where('date','<=',$this->payroll_to_date)->count();

            $payrollSummaries = Employee::distinct()->whereBetween('attendances.attendance_date',[$this->payroll_from_date,$this->payroll_to_date])
           ->where('attendances.attendance_status','unpaid')
           ->leftJoin('attendances', 'attendances.biometric_id', '=', 'employees.biometric_id')
           ->leftJoin('holidays', 'holidays.date', '=', 'attendances.attendance_date')
           ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->groupBy(['employees.id', 'attendances.biometric_id'])
           ->selectRaw('employees.*,positions.salary_rate,
            ROUND(SUM('.$first_in.')) AS total_regular_hours,
            SUM(ROUND('.$first_in.' *  '.$regular_salary_holiday.')) AS total_salarypay_with_tax,
            SUM(ROUND(('.$first_in.')  * '.$regular_salary_holiday.' - (('.$first_in.')*(positions.salary_rate))/8       )) AS regularholiday_pay,
            SUM(ROUND(('.$first_in.' )  * (positions.salary_rate * 1 /8) )) AS total_regular_pay,
   
   
            IFNULL(SUM(ROUND( '.$overtime_in.' )),0) AS total_overtime_hours,
            IFNULL(SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' )),0) AS total_overtimepay_with_tax,
            IFNULL(SUM(ROUND(('.$overtime_in.' )  * (positions.salary_rate * 1 /8) )),0) AS total_overtime_pay,
            ifnull(SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' - (('.$overtime_in.' )*(positions.salary_rate))/8 )),0) AS overtimeholiday_pay,

            SUM(ROUND('.$first_in.' *  '.$regular_salary_holiday.')) + 
            IFNULL(SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' )),0) - 
            IFNULL((SELECT SUM(cash_amount) FROM cash_advances WHERE employee_id = employees.id),0) as total_minus_cashadvances')
            ->havingRaw('SUM(ROUND('.$first_in.' *  '.$regular_salary_holiday.')) + 
            IFNULL(SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' )),0) - 
            IFNULL((SELECT SUM(cash_amount) FROM cash_advances WHERE employee_id = employees.id),0) > 0');;

            
            if($this->project_id && $this->project_id != 0){
                $payrollSummaries = $payrollSummaries->where('employees.project_id',$this->project_id);
                 }
          


        $this->payrollSummaries = $payrollSummaries;
        $this->first_in = $first_in;
        $this->holidays = $holidays;
        $this->overtime_in = $overtime_in;
        $this->regular_salary_holiday = $regular_salary_holiday;
        $this->overtime_salary_holiday = $overtime_salary_holiday;

        
    }
    public function render()
    {
        $payrolls = $this->payrolls;
        $cash_adv = $this->cash_adv;
        $first_in = $this->first_in;
        $overtime_in = $this->overtime_in;
        $regular_salary_holiday = $this->regular_salary_holiday;
        $overtime_salary_holiday = $this->overtime_salary_holiday;
        $payrollSummaries =  $this->payrollSummaries ;
        $searchTerm = $this->searchTerm;
    
        $holidays = Holiday::where('date','>=',$this->payroll_from_date)->where('date','<=',$this->payroll_to_date)->count();
        if($payrolls->approved_by){

            $printedPayrolls = PayrollSummary::where('payroll_id',$this->selected_payroll)
            ->where('employee_name', 'LIKE', "%{$searchTerm}%");
            $printedPayrolls = $printedPayrolls->paginate(5);

            return view('livewire.admin.payroll.summary-payroll',compact('printedPayrolls','payrolls','holidays'))->layout('layouts.master');
         }
         else
         {
          
            //Overtime time in / total working hours in the day(time in - timeout) if time_out is null then overtime is voided or = 0 ot hours in the day
           $payrollSummaries = $payrollSummaries->paginate(5);
           $attendances = Attendance::has('employees')->orderBy('attendance_date','desc')->orderBy('first_onDuty','asc')
           ->paginate(5);

        //    dd($payrollSummaries);
            return view('livewire.admin.payroll.preview-payroll',compact('payrollSummaries','payrolls','holidays','cash_adv','attendances'))->layout('layouts.master');
         }
    }


    public function bulkPayslipPDF()
    {   
        $payroll_to_date = Carbon::parse($this->payroll_to_date)->format('F d, Y');
        $payroll_from_date = Carbon::parse($this->payroll_from_date)->format('F d, Y');
        $holidays = $this->holidays;
        $payrolls = $this->payrolls;

        if($payrolls->payroll_status != "pending"){
        try {
        $printedPayrolls = PayrollSummary::with('employees.position')->where('payroll_id',$this->selected_payroll)->paginate(5);
        view()->share('printedPayrolls',$printedPayrolls);
        
        $pdf = PDF::loadView('livewire.admin.payroll.all-payslip', compact('printedPayrolls','holidays','payrolls'))->setPaper('a4')
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
            'text'  => "Payroll successfully printed.<br><small> Please reload the page to see changes. </small>",
        ],
        );
    return $pdf->stream('payslip.pdf') ;
        }catch(Exception $ex){
            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Error!!',
                'text'  => "Submition for payroll failed {$ex->getMessage()}",
            ]);
        }

     }

    }

    public function printSinglePayslip($id)
    {   
        $payroll_to_date = Carbon::parse($this->payroll_to_date)->format('F d, Y');
        $payroll_from_date = Carbon::parse($this->payroll_from_date)->format('F d, Y');
        $holidays = $this->holidays;
        $payrolls = $this->payrolls;

        if($payrolls->payroll_status != "pending"){
        try {
       
        $printedPayrolls = PayrollSummary::with('employees.position')->where('payroll_id',$this->selected_payroll)->where('id',$id)->get();
      
        view()->share('printedPayrolls',$printedPayrolls);
        
        $pdf = PDF::loadView('livewire.admin.payroll.all-payslip', compact('printedPayrolls','holidays','payrolls'))->setPaper('a4')
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
            'text'  => "Payroll successfully printed.<br><small> Please reload the page to see changes. </small>",
        ],
        );

    return $pdf->stream('payslip.pdf') ;


        }catch(Exception $ex){
            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Error!!',
                'text'  => "Submition for payroll failed {$ex->getMessage()}",
            ]);
        }

     }

    }



    public function approved($id)
    {   
        $payrollSummaries =  $this->payrollSummaries ;
        
        try {
        $payroll = Payroll::find($id);
        $payroll_from_date =  $payroll->payroll_from_date;
        $payroll_to_date = $payroll->payroll_to_date;

        //get payroll summary // mounted
        $payrollSummaries = $payrollSummaries->paginate(5);


        
    // INSERT ALL ROWS IN THE LOOP IN THE PAYROLL_SUMMARY TABLE
    if($payroll->payroll_status != "approved" && $payroll->payroll_status != null && $payroll->payroll_status == "pending"){

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
            // $this->payroll_status = $payroll->payroll_status;
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


    public function viewAttendance($id) {
        $payrollSummaries =  $this->payrollSummaries ;
            
        $this->employee_preview_biometric_id = $id;

    }
}
