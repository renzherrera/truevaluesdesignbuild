<?php

namespace App\Http\Livewire\Admin\Attendance;

use App\Models\Attendance;
use Livewire\Component;

class WidgetAttendance extends Component
{
    public $noTimeOutRecords,$lateCounts,$search;
   
    public function render()
    {
        $lateCounts = Attendance::has('employees')->whereRaw('attendances.first_onDuty > schedules.start_time')->orderBy('attendance_date','desc')->orderBy('first_onDuty','asc')
        ->leftJoin('employees', 'attendances.biometric_id', '=', 'employees.biometric_id')
        ->leftJoin('schedules', 'schedules.id', '=', 'employees.schedule_id');
        

        $lateCounts = $lateCounts->count();

        $this->lateCounts = $lateCounts;
        $this->noTimeOutRecords = Attendance::has('employees')->where('second_onDuty',null)->count();
        // $attendances->employees->schedule->pluck('start_time');
        return view('livewire.admin.attendance.widget-attendance');
    }
}
