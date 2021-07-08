<?php

namespace App\Http\Livewire\Admin\Payroll;

use App\Models\Payroll;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
class ListPayroll extends Component
{
    public $payroll_from_date ,$payroll_to_date,$payroll_description,$createMode = true, $updateMode= false, $selected_id,$searchTerm;
    use WithPagination;
    public function render()
    {

        $searchTerm=$this->searchTerm;
        $payrolls = Payroll::orderBy('id','desc')
        ->orWhere('id', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_description', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_from_date', 'LIKE', "%{$searchTerm}%")
        ->orWhere('payroll_to_date', 'LIKE', "%{$searchTerm}%")
        ->paginate(5);
        return view('livewire.admin.payroll.list-payroll', compact('payrolls'))->layout('layouts.master');
    }
    public function updatingSearchTerm(): void
    {
        $this->gotoPage(1);
    }

    public function store() {
        $this->validate([
            'payroll_from_date' => 'required|date',
            'payroll_to_date' => 'required|date',      
            'payroll_description' => 'required',
           
        ]); 


         Payroll::create([
            'payroll_from_date' => $this->payroll_from_date,
            'payroll_to_date' => $this->payroll_to_date,
            'payroll_description' => $this->payroll_description,
            'payroll_status' => "Not Printed",
        ]);
        $this->resetInputFields();
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Payroll Added",
        ]);

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

        $payroll = Payroll::findOrFail($id);
        $this->selected_id = $id;
        $this->payroll_from_date = $payroll->payroll_from_date;
        $this->payroll_to_date = $payroll->payroll_to_date;
        $this->payroll_description = $payroll->payroll_description;

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
            'payroll_status' => "Not Printed",
        ]);
        $this->updateMode = false;


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
        $this->updateMode = false;
        $this->resetInputFields();
    }

}
