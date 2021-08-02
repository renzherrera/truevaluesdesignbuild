<?php

namespace App\Http\Livewire\Admin\Payroll;

use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\PayrollSummary;
use Livewire\Component;

class PayrollWidget extends Component
{
    public function render()
    {
    $payrolls = $this->allPayrolls();
    $approvedCounts = $this->getTotalSalary()->where('payrolls.payroll_status','approved')->count();
    $pendingCounts = $this->getTotalPendingSalary()->count();
    $pendingSalary = $this->getTotalPendingSalary()->sum('total_minus_cashadvances');
    $approvedSalary = $this->getTotalSalary()->where('payrolls.payroll_status','approved')->get()->sum('total_net_pay');
    $paidSalary = $this->getTotalSalary()->where('payrolls.payroll_status','paid')->get()->sum('total_net_pay');
    $paidCounts = $this->getTotalSalary()->where('payrolls.payroll_status','paid')->count();

    $totalSalary = $this->getTotalSalary()->sum('total_net_pay');
        return view('livewire.admin.payroll.payroll-widget',compact('payrolls','approvedCounts','pendingCounts','totalSalary','pendingSalary','paidSalary','approvedSalary','paidCounts'));
    }

    function getApprovedCounts() {
        // $searchTerm = $this->searchTerm;
        $payrolls = Payroll::orderBy('id','desc')->where('approved_by','!=', null)->get();
        // if($searchTerm){
        // $payrolls = $payrolls
        // ->orWhere('id', 'LIKE', "%{$searchTerm}%")
        // ->orWhere('payroll_description', 'LIKE', "%{$searchTerm}%")
        // ->orWhere('payroll_from_date', 'LIKE', "%{$searchTerm}%")
        // ->orWhere('payroll_to_date', 'LIKE', "%{$searchTerm}%");
        // }
        // if($this->start && $this->end){
        //     $payrolls = $payrolls
        //     ->whereBetween('payroll_from_date',[$this->start,$this->end]);
        // }

        // if($this->filter_project){
        //     $payrolls = $payrolls->where('project_id',$this->filter_project);
        // }
       return $payrolls = $payrolls->count();

    }

    function getPendingCounts() {
        $payrolls = Payroll::orderBy('id','desc')->where('approved_by','=', null)->where('prepared_by','!=',null)->where('payroll_status','pending')->get();
    
       return $payrolls = $payrolls->count();

    }

    function getTotalSalary() {
        $payrollSalary = PayrollSummary::select('payroll_summary.total_net_pay','payroll_summary.project_id','payroll_summary.payroll_from_date','payroll_summary.payroll_to_date')
        ->join('payrolls','payrolls.id','=','payroll_summary.payroll_id');
     
        return $payrollSalary;
    }

    
    function getPaidSalary() {
        $payrollSalary = PayrollSummary::select('payroll_summary.total_net_pay','payroll_summary.project_id','payroll_summary.payroll_from_date','payroll_summary.payroll_to_date')
        ->where('payrolls.payroll_status','=','paid')
        ->join('payrolls','payrolls.id','=','payroll_summary.payroll_id')
        ->get();
     
        return $payrollSalary;
    }
    
    

    function getTotalPendingSalary() {
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

            $payrollSummaries = Employee::where('attendances.attendance_status','unpaid')
           ->leftJoin('attendances', 'attendances.biometric_id', '=', 'employees.biometric_id')
           ->leftJoin('holidays', 'holidays.date', '=', 'attendances.attendance_date')
           ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->groupBy(['employees.id', 'attendances.biometric_id'])
           ->selectRaw('employees.*,positions.salary_rate,
   

            SUM(ROUND('.$first_in.' *  '.$regular_salary_holiday.')) + 
            IFNULL(SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' )),0) - 
            IFNULL((SELECT SUM(cash_amount) FROM cash_advances WHERE employee_id = employees.id AND status = "approved"),0) as total_minus_cashadvances')
            ->havingRaw('SUM(ROUND('.$first_in.' *  '.$regular_salary_holiday.')) + 
            IFNULL(SUM(ROUND(('.$overtime_in.' )  * '.$overtime_salary_holiday.' )),0) - 
            IFNULL((SELECT SUM(cash_amount) FROM cash_advances WHERE employee_id = employees.id AND status = "approved"),0) > 0');
        return $payrollSummaries;
    }
    function allPayrolls() {

       
        // $searchTerm = $this->searchTerm;
        $payrolls = Payroll::orderBy('id','desc')->get();
      
       return $payrolls = $payrolls->count();
    }

}
