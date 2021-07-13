<?php

namespace App\Http\Livewire\Admin\Position;

use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class ListPosition extends Component
{
    use WithPagination;
    public $searchTerm, $updateMode = false, $position_title, $job_description,$salary_rate, $selected_id, $has_holiday;
    public function render()
    {
        $searchTerm='%'.$this->searchTerm . '%';
        $positions = Position::where('position_title', 'LIKE', $searchTerm )
                    ->paginate(5);
        return view('livewire.admin.position.list-position',compact('positions'))->layout('layouts.master');
    }

    public function updatingSearchTerm(): void
    {
        $this->gotoPage(1);
    }


    public function destroy(Position $position) {
            $position->delete();
    }

    public function back() {
        $this->updateMode = false;
        $this->resetFields();
    }
   
    
    public function edit($id)
    {
        $this->updateMode = true;

        $positions = Position::findOrFail($id);
        $this->selected_id = $id;
        $this->position_title = $positions->position_title;
        $this->job_description = $positions->job_description;
        $this->salary_rate = $positions->salary_rate;
    }

    
    
    public function store()
    {
        $this->validate([
            'position_title' => 'required',
            'salary_rate' => 'required',
            'job_description' => 'required',
            'has_holiday' => 'required',
        ]); 
        Position::create([
            'position_title' => $this->position_title,
            'job_description' => $this->job_description,
            'salary_rate' => $this->salary_rate,
            'has_holiday' => $this->has_holiday,

        ]);


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Position Added",
        ]);
        $this->resetFields();

       
    //   return redirect()->route('admin.positions.create');  

    }

    public function update() {
        $this->validate([
            'position_title' => 'required',
            'salary_rate' => 'required',
            'job_description' => 'required',
            'has_holiday' => 'required',
        ]); 
    if ($this->selected_id) {
        $position = Position::find($this->selected_id);
        $position->update([
            'position_title' => $this->position_title,
            'job_description' => $this->job_description,
            'salary_rate' => $this->salary_rate,
            'has_holiday' => $this->has_holiday,
        ]);
        $this->updateMode = false;


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Position with ID: {$this->selected_id} successfully updated",
        ]);
        $this->resetFields();
    }
    }

    public function resetFields() {
        $this->position_title = '';
        $this->selected_id = '';
        $this->job_description = '';
        $this->salary_rate = '0.0';
        $this->has_holiday = null;
    }


    public function createPDF()
    {
       $positions = DB::table('positions')
        ->orderBy('position_title')
        ->get();
        // $projects = Project::join('project_images','projects.id','=','project_images.project_id');
        view()->share('positions',$positions);
        
        $pdf = PDF::loadView('livewire.admin.position.position-pdf', compact('positions'))->setPaper('a4');
       $pdf->setOption('header-html', view('pdf.pdf-header'));
        return $pdf->stream('position.pdf');
    }
}
