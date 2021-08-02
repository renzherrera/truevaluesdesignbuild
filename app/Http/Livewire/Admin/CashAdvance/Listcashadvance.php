<?php

namespace App\Http\Livewire\Admin\CashAdvance;

use App\Models\CashAdvance;
use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Listcashadvance extends Component
{
    public $cash_amount, $employee_id,$status, $statusTab,$requested_date,$updateMode = false,$createMode= true,$selected_id;
    use WithPagination;
    public function render()
    {
        //fill cash advance table
        $cashadvances = CashAdvance::has('employees')->orderBy('id','desc')->paginate(5);
        //fill combobox employees
        $employees = Employee::select('id','first_name','middle_name','last_name')->get();
        return view('livewire.admin.cash-advance.listcashadvance', compact('employees','cashadvances'))->layout('layouts.master');
    }

    public function store()
    {
        $this->validate([
            'employee_id' => 'required',
            'cash_amount' => 'required',
            'requested_date' => 'required',
          
        ]); 
       
        try{
        CashAdvance::create([
            'employee_id' => $this->employee_id,
            'cash_amount' => $this->cash_amount,
            'requested_date' => $this->requested_date,
            'status' => 'pending',
          
        ]);

        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Request for Cash advance succesfully submitted.",
        ]);
        $this->resetInputFields();

       }catch(Exception $ex){

        $this->emit('swal:modal', [
            'icon'  => 'error',
            'title' => 'Failed!!',
            'text'  => "Failed to submit the request. {$ex->getMessage()}",
        ]);

       }
       
       

    $this->resetInputFields();
       
    //   return redirect()->route('admin.positions.create');  

    }

    public function edit($id){
        $this->createMode = false;
        $this->updateMode = true;

        $cashadvance = CashAdvance::findOrFail($id);
        $this->selected_id = $id;
        $this->employee_id = $cashadvance->employee_id;
        $this->requested_date = $cashadvance->requested_date;
        $this->cash_amount = $cashadvance->cash_amount;
    }

    public function update() {
        $this->validate([
            'employee_id' => 'required',
            'cash_amount' => 'required',
            'requested_date' => 'required',
          
        ]); 
       
        try {

    if ($this->selected_id) {
        $cashadvance = CashAdvance::find($this->selected_id);
        $cashadvance->update([
            'employee_id' => $this->employee_id,
            'cash_amount' => $this->cash_amount,
            'requested_date' => $this->requested_date,
        ]);
        $this->updateMode = false;
        $this->updateMode = true;
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Cash Advance record updated",
        ]);
        $this->resetInputFields();

         } //endif
        } catch(Exception $ex){
            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Failed!!',
                'text'  => "Unable to update records. {$ex->getMessage()}",
            ]);
        }

    }

    public function destroy(CashAdvance $cashadvance){
        try{
            $cashadvance->delete();
            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => 'Success!!',
                'text'  => "Cash-advance record with id [{$cashadvance->id}] successfully deleted!",
            ]);
        }catch(Exception $ex){
            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Failed!!',
                'text'  => "Unable to update records. {$ex->getMessage()}",
            ]);
        }catch(\Error $ex){
            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Failed!!',
                'text'  => "Unable to update records. {$ex->getMessage()}",
            ]);
        }
    }
    public function resetInputFields(){
        $this->cash_amount = null;
        $this->employee_id = null;
        $this->requested_date = null;
        $this->selected_id = null;
    
    }

    public function createMode() {
        $this->updateMode=false;
        $this->createMode=true;
        $this->resetInputFields();
        
    }

    // approve function only superadmin can see this
    public function approved($id) {

        $cashadvance = CashAdvance::find($id);
        if(!$cashadvance->approved_by && Auth::user()->role == "superadmin"){

        $cashadvance->update([
            'approved_by' => Auth::user()->id,
            'status' => "approved",
        ]);


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Cash advance for {$cashadvance->employees->first_name} successfully approved!",
        ]);
        $this->resetInputFields();
        }
    }

    function revertPending($id) {

        $cashadvance = CashAdvance::find($id);
        if($cashadvance->approved_by && Auth::user()->role == "superadmin"){

        $cashadvance->update([
            'approved_by' => null,
            'status' => "pending",
        ]);


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Cash advance for {$cashadvance->employees->first_name} successfully reverted!",
        ]);
        }

    }
}
