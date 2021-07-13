<?php

namespace App\Http\Livewire\Admin\Holiday;

use App\Models\Holiday;
use Livewire\Component;
use Livewire\WithPagination;
class ListHoliday extends Component
{
    public $updateMode = false, $createMode = true, $holiday_name, $rate, $ot_rate, $date, $selected_id;
    use WithPagination;
    public function render()
    {
        $holidays = Holiday::paginate(5);
        return view('livewire.admin.holiday.list-holiday', compact('holidays'))->layout('layouts.master');
    }

    public function store() {

        $this->validate([
            'holiday_name' => 'required',
            'rate' => 'required',     
            'ot_rate' => 'required',
            'date' => 'required',      
           
        ]); 

         Holiday::create([
            'holiday_name' => $this->holiday_name,
            'rate' => $this->rate,
            'ot_rate' => $this->ot_rate,
            'date' => $this->date,
        ]);
        $this->resetInputFields();
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Holiday successfully created.",
        ]);

    }
    public function edit($id){

        $this->updateMode = true;
        $this->createMode = false;
        $holiday = Holiday::findOrFail($id);
        $this->selected_id = $id;

        $this->holiday_name = $holiday->holiday_name;
        $this->rate = $holiday->rate;
        $this->ot_rate = $holiday->ot_rate;
        $this->date = $holiday->date;

    }

    public function resetInputFields()
    {
        $this->holiday_name='';
        $this->rate='';
        $this->ot_rate='';
        $this->date='';
  
    
    }

    public function createMode() {
        $this->createMode = true;
        $this->updateMode = false;
        $this->resetInputFields();
    }



    public function update() {
        $this->validate([
            'holiday_name' => 'required',
            'rate' => 'required',     
            'ot_rate' => 'required',
            'date' => 'required',      
           
        ]); 

        if($this->selected_id){
        $holiday = Holiday::findOrFail($this->selected_id);
        $holiday->update([
                'holiday_name' => $this->holiday_name,
                'rate' => $this->rate,
                'ot_rate' => $this->ot_rate,
                'date' => $this->date,
            ]);
            $this->resetInputFields();
            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => 'Success!!',
                'text'  => "Holiday updated successfully .",
            ]);
        }
        
    }





    public function destroy(Holiday $holiday){

        $holiday->delete();
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Holiday successfully deleted.",
        ]);
    }
}
