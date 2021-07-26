<?php

namespace App\Http\Livewire\Admin\Attendance;

use App\Imports\AttendanceImport;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Project;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

class ListAttendance extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $importExcelFile,$selected_id, $biometric_id, $attendance_date, $first_onDuty,$first_offDuty=null,$second_onDuty=null,$second_offDuty=null,
            $noTimeOutRecords, $start = null, $end = null, $searchTerm, $project_id, $lateCounts, $unenrolledAttendance,$unenrolledId,$earlyOutCounts,
            $updateMode = false;

    public function render()
    {
        //get attendance method for tables
        $attendances = $this->getAttendanceLists();
        //get no time out records for widgets
        $noTimeOutRecords = $this->getNoTimeOutRecords();
        //get late counts for widgets
        $lateCounts = $this->getLateRecords();
        //get late counts for widgets
        $earlyOutCounts = $this->getEarlyOut();
        //get unenrolled Id
        $unenrolledId = $this->getUnenrolledId();
        //get unenrolled attendance x
        $unenrolledAttendance = $this->getUnenrolledAttendance();
        //get projects for project filter
        $projects = Project::select('id','project_name')->get();
        //employees for create edit form fields
        $employees = Employee::select('biometric_id','first_name','middle_name','last_name')->whereNotNull('biometric_id')->get();


        $this->lateCounts = $lateCounts;
        $this->earlyOutCounts = $earlyOutCounts;
        $this->noTimeOutRecords = $noTimeOutRecords;
        $this->unenrolledAttendance = $unenrolledAttendance;
        $this->unenrolledId = $unenrolledId;
        return view('livewire.admin.attendance.list-attendance',compact('attendances','projects','employees'))->layout('layouts.master');
    }
    function getAttendanceLists() {
        $searchTerm = $this->searchTerm;
        $start =Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        $attendances = Attendance::orderBy('attendance_date','desc')->orderBy('first_onDuty','asc')
        ->whereHas('employees',function ($q) use ($searchTerm) {
            return $q->where('employees.biometric_id', '=',  $searchTerm )
            ->orWhere('employees.id',  $searchTerm)
            ->orWhere('employees.first_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('employees.middle_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('employees.last_name', 'LIKE', '%' . $searchTerm . '%');
        })->select('attendances.id as attendance_id','employees.*');

        
        if($this->project_id){
            $attendances = $attendances->where('employees.project_id',$this->project_id);
        }
        if($this->start && $this->end){
            $attendances = $attendances
            ->whereBetween('attendance_date',[$start,$end]);

            }

        return  $attendances = $attendances->leftJoin('employees', 'attendances.biometric_id', '=', 'employees.biometric_id')->paginate(5);
        
    }

    function getNoTimeOutRecords() {
        $searchTerm = $this->searchTerm;
        $start =Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        $noTimeOutRecords = Attendance::has('employees')
        ->where(function ($q) use ($searchTerm) {
            return $q->where('employees.biometric_id', '=',  $searchTerm )
            ->orWhere('employees.first_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('employees.middle_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('employees.last_name', 'LIKE', '%' . $searchTerm . '%');
        })
        ->where('second_onDuty',null)->where('first_offDuty',null);

        if($this->project_id){
            $noTimeOutRecords = $noTimeOutRecords->where('employees.project_id',$this->project_id);
        }

        if($this->start && $this->end){
           
            $noTimeOutRecords = $noTimeOutRecords
            ->whereBetween('attendance_date',[$start,$end]);
    
            }
       return $noTimeOutRecords = $noTimeOutRecords
        ->join('employees', 'attendances.biometric_id', '=', 'employees.biometric_id')
        ->join('schedules', 'schedules.id', '=', 'employees.schedule_id')
        ->count();

    }

    function getLateRecords(){
        $searchTerm = $this->searchTerm;
        $start =Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        //late counts
        $lateCounts = Attendance::has('employees')->
        where(function ($q) use ($searchTerm) {
            return $q->where('employees.biometric_id', '=',  $searchTerm )
            ->orWhere('employees.first_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('employees.middle_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('employees.last_name', 'LIKE', '%' . $searchTerm . '%');
        })
        ->whereRaw('attendances.first_onDuty > date_add(schedules.start_time,interval 15 minute)');

        if($this->project_id){
            $lateCounts = $lateCounts->where('employees.project_id',$this->project_id);
        }

        if($this->start && $this->end){

        $lateCounts = $lateCounts
        ->whereBetween('attendance_date',[$start,$end]);
        }

       return $lateCounts = $lateCounts
        ->join('employees', 'attendances.biometric_id', '=', 'employees.biometric_id')
        ->join('schedules', 'schedules.id', '=', 'employees.schedule_id')->count();
    }

    function getEarlyOut(){
        $searchTerm = $this->searchTerm;
        $start =Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        //late counts
        $earlyOutCounts = Attendance::has('employees')->
        where(function ($q) use ($searchTerm) {
            return $q->where('employees.biometric_id', '=',  $searchTerm )
            ->orWhere('employees.first_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('employees.middle_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('employees.last_name', 'LIKE', '%' . $searchTerm . '%');
        })
        ->whereRaw('attendances.first_offDuty < schedules.end_time or attendances.second_onDuty < schedules.end_time and 
        TIMESTAMPDIFF(minute, CONCAT(attendances.attendance_date," ",attendances.first_onDuty),
        IFNULL(CONCAT(attendances.attendance_date," ",attendances.first_offDuty),IFNULL(CONCAT(attendances.attendance_date," ",second_onDuty),CONCAT(attendances.attendance_date," ","12:00:00" ))  )  ) <480');

        if($this->project_id){
            $earlyOutCounts = $earlyOutCounts->where('employees.project_id',$this->project_id);
        }

        if($this->start && $this->end){

        $earlyOutCounts = $earlyOutCounts
        ->whereBetween('attendance_date',[$start,$end]);
        }

       return $earlyOutCounts = $earlyOutCounts
        ->join('employees', 'attendances.biometric_id', '=', 'employees.biometric_id')
        ->join('schedules', 'schedules.id', '=', 'employees.schedule_id')->count();
    }

    function getUnenrolledAttendance() {
        $start =Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        $unenrolledAttendance = Attendance::doesntHave('employees');
        if($this->start && $this->end){
        $unenrolledAttendance = $unenrolledAttendance
        ->whereBetween('attendance_date',[$start,$end]);
        }
     
       return $unenrolledAttendance = $unenrolledAttendance->get()->count();

    }

    function getUnenrolledId() {
        $start =Carbon::parse($this->start)->toDateTimeString();
        $end = Carbon::parse($this->end)->toDateTimeString();
        $unenrolledId = Attendance::select('biometric_id')->doesntHave('employees')->groupBy('biometric_id');
        if($this->start && $this->end){
        $unenrolledId = $unenrolledId
        ->whereBetween('attendance_date',[$start,$end]);
        }
     
       return $unenrolledId = $unenrolledId->get()->count();

    }
    public function updatingSearchTerm(): void
    {
        $this->gotoPage(1);
    }
    public function store()
    {
        $this->validate([
            'biometric_id' => 'required',
            'attendance_date' => 'required',
            'first_onDuty' => 'required',
        ]); 
        $attendance = Attendance::select('biometric_id')->where('biometric_id','=', $this->biometric_id)
        ->where('attendance_date','=',$this->attendance_date)
        ->get();
        if($attendance->count() < 1){
        Attendance::create([
            'biometric_id' => $this->biometric_id,
            'attendance_date' => $this->attendance_date,
            'first_onDuty' => $this->first_onDuty,
            'first_offDuty' => $this->first_offDuty,
            'second_onDuty' => $this->second_onDuty,
            'second_offDuty' => $this->second_offDuty,
        ]);
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Position Added",
        ]);
        $this->resetInputFields();
    }else{
        $this->emit('swal:modal', [
            'icon'  => 'error',
            'title' => 'Failed!!',
            'text'  => "The employee with Biometric ID of {$this->biometric_id} has already record on that date",
        ]);
    }
    $this->resetInputFields();

    }
    
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        if($attendance->attendance_status == "unpaid"){
        // $this->createMode = false;
        $this->updateMode = true;
        $this->selected_id = $id;
        $this->biometric_id = $attendance->biometric_id;
        $this->attendance_date = $attendance->attendance_date;
        $this->first_onDuty = $attendance->first_onDuty;
        $this->first_offDuty = $attendance->first_offDuty;
        $this->second_onDuty = $attendance->second_onDuty;
        $this->second_offDuty = $attendance->second_offDuty;

    }else{
        $this->emit('swal:modal', [
            'icon'  => 'info',
            // 'title' => 'Success!!',
            'text'  => 'You cannot edit attendance if it was already paid. <br> <small>If you still wish to do that, you have to delete the payroll where this attendance existed</small>',
        ]);
    }
    }

    public function import(){
        $this->validate([
            'importExcelFile' => 'required'
        ]);
        try{
            Excel::import(new AttendanceImport, $this->importExcelFile);
            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => 'Success!!',
                'text'  => "New Attendance Added",
            ]);
            $this->resetInputFields();

        }catch(Exception $ex){

            $this->emit('swal:alert', [
                'icon'  => 'error',
                'title' => "Importation failed {$ex->getMessage()}",
            ]);

        }

        $this->resetInputFields();

     
    }
   


    public function resetInputFields()
    {
        $this->importExcelFile='';
        $this->biometric_id='';
        $this->attendance_date=null;
        $this->first_onDuty=null;
        $this->first_onDuty=null;
        $this->first_offDuty=null;
        $this->second_onDuty=null;
        $this->second_offDuty=null;
            
    }

    public function update() {
        $this->validate([
            'biometric_id' => 'required',
            'attendance_date' => 'required',
            'first_onDuty' => 'required',
          
        ]); 
       
        
    if ($this->selected_id) {
        $attendance = Attendance::find($this->selected_id);
        $attendance->update([
            'biometric_id' => $this->biometric_id,
            'attendance_date' => $this->attendance_date,
            'first_onDuty' => $this->first_onDuty,
            'first_offDuty' => $this->first_offDuty,
            'second_onDuty' => $this->second_onDuty,
            'second_offDuty' => $this->second_offDuty,
        ]);
        $this->updateMode = false;


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Position with ID: {$this->selected_id} successfully updated",
        ]);
        $this->resetInputFields();

    }
    }

    public function destroy(Attendance $attendance) {
        try{
            $attendance->delete();
            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => 'Success!!',
                'text'  => "Attendance with Biometric ID: {$attendance->biometric_id} successfully deleted",
            ]);

        }catch(Exception $ex){

            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Error!!',
                'text'  => "Unable to delete! {$ex->getMessage()}",
            ]);
        }
      
    }

    public function createMode() {
        // $this->createMode = true;
        $this->updateMode = false;
        $this->resetInputFields();
    }
}
