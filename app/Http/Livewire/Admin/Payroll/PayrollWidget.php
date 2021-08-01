<?php

namespace App\Http\Livewire\Admin\Payroll;

use App\Models\Payroll;
use App\Models\PayrollSummary;
use Livewire\Component;

class PayrollWidget extends Component
{
    public function render()
    {
    $payrolls = $this->allPayrolls();
    $approvedCounts = $this->getApprovedCounts();
    $pendingCounts = $this->getPendingCounts();
    $totalSalary = $this->getTotalSalary();
        return view('livewire.admin.payroll.payroll-widget',compact('payrolls','approvedCounts','pendingCounts','totalSalary'));
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
        // $searchTerm = $this->searchTerm;
        $payrolls = Payroll::orderBy('id','desc')->where('approved_by','=', null)->where('prepared_by','!=',null)->where('payroll_status','pending')->get();
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

    function getTotalSalary() {
        $payrollSalary = PayrollSummary::select('total_net_pay','project_id','payroll_from_date','payroll_to_date')->get();
        // if($this->start && $this->end){
        //     $payrollSalary = $payrollSalary
        //     ->whereBetween('payroll_from_date',[$this->start,$this->end]);
        //     // ->orWhereBetween('payroll_to_date',[$this->start,$this->end]);
        // }
        //     if($this->filter_project !=0){
        //     $payrollSalary = $payrollSalary->where('project_id','=',$this->filter_project);
        //       }
        return $payrollSalary->sum('total_net_pay');
    }

    function allPayrolls() {

       
        // $searchTerm = $this->searchTerm;
        $payrolls = Payroll::orderBy('id','desc')->get();
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

}
