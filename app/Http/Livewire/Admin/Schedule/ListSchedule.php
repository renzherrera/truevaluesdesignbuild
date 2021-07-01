<?php

namespace App\Http\Livewire\Admin\Schedule;

use App\Models\Schedule;
use Livewire\Component;
use Livewire\WithPagination;

class ListSchedule extends Component
{
    use WithPagination;
    public $updateMode = false,$end_time,$start_time,$schedule_title, $selected_id;
    public function render()
    {
        $schedules = Schedule::paginate(5);
        return view('livewire.admin.schedule.list-schedule',compact('schedules'))->layout('layouts.master');
    }
      
    public function store()
    {
        $this->validate([
            'schedule_title' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]); 
        Schedule::create([
            'schedule_title' => $this->schedule_title,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,

        ]);


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Schedule Added",
        ]);

       $this->resetFields();
    //   return redirect()->route('admin.positions.create');  

    }
    public function edit($id)
    {
        $this->updateMode = true;

        $schedule = Schedule::findOrFail($id);
        $this->selected_id = $id;
        $this->schedule_title = $schedule->schedule_title;
        $this->start_time = $schedule->start_time;
        $this->end_time = $schedule->end_time;
    }
    public function update() {
        $this->validate([
            'schedule_title' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]); 
    if ($this->selected_id) {
        $schedule = Schedule::find($this->selected_id);
        $schedule->update([
            'schedule_title' => $this->schedule_title,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time
        ]);
        $this->updateMode = false;


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Schedule with ID: {$this->selected_id} successfully updated",
        ]);
        $this->resetFields();
    }
    }

    public function destroy(Schedule $schedule) {
        $schedule->delete();
}

    public function back() {
        $this->updateMode = false;
        $this->resetFields();
    }
    
    public function resetFields() {
        $this->schedule_title = '';
        $this->start_time = '';
        $this->end_time = '';
    }

}
