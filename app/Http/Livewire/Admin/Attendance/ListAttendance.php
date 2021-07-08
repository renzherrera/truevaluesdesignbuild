<?php

namespace App\Http\Livewire\Admin\Attendance;

use App\Imports\AttendanceImport;
use App\Models\Attendance;
use App\Models\Employee;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

class ListAttendance extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $importExcelFile,$selected_id, $biometric_id, $attendance_date, $first_onDuty,$first_offDuty=null,$second_onDuty=null,$second_offDuty=null,
            $createMode = true, $updateMode= false;
    public function render()
    {
        
        $employees = Employee::select('biometric_id','first_name','middle_name','last_name')->whereNotNull('biometric_id')->get();
        $attendances = Attendance::has('employees')->orderBy('attendance_date','desc')->orderBy('first_onDuty','asc')
        ->paginate(5);

        return view('livewire.admin.attendance.list-attendance',compact('attendances','employees'))->layout('layouts.master');
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
       
    //   return redirect()->route('admin.positions.create');  

    }
    
    public function edit($id)
    {
        $this->createMode = false;
        $this->updateMode = true;

        $attendance = Attendance::findOrFail($id);
        $this->selected_id = $id;
        $this->biometric_id = $attendance->biometric_id;
        $this->attendance_date = $attendance->attendance_date;
        $this->first_onDuty = $attendance->first_onDuty;
        $this->first_offDuty = $attendance->first_offDuty;
        $this->second_onDuty = $attendance->second_onDuty;
        $this->second_offDuty = $attendance->second_offDuty;

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
            $this->resetInputFields();

            $this->emit('swal:alert', [
                'icon'  => 'error',
                'title' => "Importation failed {$ex->getMessage()}",
            ]);

        }

        $this->resetInputFields();

     
    }
   


    public function resetInputFields()
    {
        $this->importExcelFile=null;
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
        $this->createMode = true;
        $this->updateMode = false;
        $this->resetInputFields();
    }
}
