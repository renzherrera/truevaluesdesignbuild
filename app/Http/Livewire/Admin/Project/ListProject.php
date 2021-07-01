<?php

namespace App\Http\Livewire\Admin\Project;

use App\Models\Project;
use Livewire\Component;

class ListProject extends Component
{
    public $updateMode = false,$project_name,$project_owner, $project_type,$project_started=null,$project_ended=null,$project_location,$project_status, $project_description,$estimated_budget, $searchTerm;

    public function render()
    {
        return view('livewire.admin.project.list-project')->layout('layouts.master');
    }

     
    public function store()
    {
        $this->validate([
            'project_name' => 'required',
            'project_owner' => 'required',      
            'project_type' => 'required',
            'project_location' => 'required',
            'project_status' => 'required',
            'project_description' => 'required',
        ]); 
        $project = Project::create([
            'project_name' => $this->project_name,
            'project_owner' => $this->project_owner,
            'project_type' => $this->project_type,
            'project_started' => $this->project_started !== null ? date('Y-m-d H:i:s', strtotime($this->project_started)) : null,
            'project_ended' => $this->project_ended !== null ? date('Y-m-d H:i:s', strtotime($this->project_ended)) : null,
            'project_location' => $this->project_location,
            'project_status' => $this->project_status,
            'project_description' => $this->project_description,
            'estimated_budget' => $this->estimated_budget,
        ]);


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Project Added",
        ]);
        $this->resetFields();

       
    //   return redirect()->route('admin.positions.create');  

    }

    public function resetFields() {
        $this->project_name = '';
        $this->selected_id = '';
        $this->job_description = '';
        $this->salary_rate = '0.0';
    }

}
