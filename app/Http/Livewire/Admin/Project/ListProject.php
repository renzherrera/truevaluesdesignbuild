<?php

namespace App\Http\Livewire\Admin\Project;

use App\Models\Project;
use App\Models\ProjectService;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;
class ListProject extends Component
{
    public $updateMode = false, $createMode = false, $listMode = true,
    $project_name,$project_owner, $project_started=null,$project_ended=null,
    $project_location,$project_status, $project_description,$estimated_budget, $searchTerm, $selected_id;
    public $project_type =[];
    use WithPagination;
    public function render()
    {
        $selected = null;
        if($this->selected_id){
            $selected = Project::with('services')->findOrFail($this->selected_id);

        }

        $services = Service::select('id','service_name')->get();
        $searchTerm='%'.$this->searchTerm . '%';
        $projects = Project::where('project_name', 'LIKE', $searchTerm )
                    ->paginate(5);
        return view('livewire.admin.project.list-project',compact('projects','services','selected'))->layout('layouts.master');
    }

     
    public function store()
    {
        $this->validate([
            'project_name' => 'required',
            'project_owner' => 'required',      
            // 'project_type' => 'required',
            'project_location' => 'required',
            'project_status' => 'required',
            'project_description' => 'required',
        ]); 
        $project = Project::create([
            'project_name' => $this->project_name,
            'project_owner' => $this->project_owner,
            'project_type' => json_encode($this->project_type),
            'project_started' => $this->project_started !== null ? date('Y-m-d H:i:s', strtotime($this->project_started)) : null,
            'project_ended' => $this->project_ended !== null ? date('Y-m-d H:i:s', strtotime($this->project_ended)) : null,
            'project_location' => $this->project_location,
            'project_status' => $this->project_status,
            'project_description' => $this->project_description,
            'estimated_budget' => $this->estimated_budget,
        ]);

        // encoded type so I can loop json array 
        $type =  json_encode($this->project_type);
       //decoded to get each values and insert
        $service_types = json_decode($type,true);

        foreach($service_types as $key){
           $project->services()->attach($key);

        }


        // foreach($service_types as $key){
        //     ProjectService::create([
        //         'project_id' => $project->id,
        //         'service_id' => $key,
        //     ]);

        // }
        
        $this->resetInputFields();

        $this->emit('productServiceStore');
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Project Added",
        ]);

       
    //   return redirect()->route('admin.positions.create');  

    }

    public function resetInputFields()
    {
        $this->project_name='';
        $this->project_owner='';
        $this->project_type='';
        $this->project_status= '';
        $this->project_started=null;
        $this->project_ended=null;
        $this->project_location='';
        $this->project_description='';
        $this->estimated_budget='0.0';
        $this->project_type=null;

    
    }
    public function createMode() {
        $this->createMode = true;
        $this->updateMode = false;
        $this->listMode = false;
    }

    public function listMode() {
        $this->createMode = false;
        $this->updateMode = false;
        $this->listMode = true;
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->createMode = false;
        $this->updateMode = true;
        $this->listMode = false;

        $projects = Project::with('services')->findOrFail($id);
        $this->selected_id = $id;
        $this->project_name = $projects->project_name;
        $this->project_owner = $projects->project_owner;
        // $this->project_type= $projects->project_type;
        $this->project_status= $projects->project_status;
        $this->project_started=$projects->project_started;
        $this->project_ended=$projects->project_ended;
        $this->project_location=$projects->project_location;
        $this->project_description=$projects->project_description;
        $this->estimated_budget=$projects->estimated_budget;
        $this->dispatchBrowserEvent('reApplySelect2');

    }

    public function update() {
        $this->validate([
            'project_name' => 'required',
            'project_owner' => 'required',      
            'project_location' => 'required',
            'project_status' => 'required',
            'project_description' => 'required',
        ]); 
    if ($this->selected_id) {
        $project = Project::find($this->selected_id);
        $project->update([
            'project_name' => $this->project_name,
            'project_owner' => $this->project_owner,
            // 'project_type' => $this->project_type,
            'project_started' => $this->project_started !== null ? date('Y-m-d H:i:s', strtotime($this->project_started)) : null,
            'project_ended' => $this->project_ended !== null ? date('Y-m-d H:i:s', strtotime($this->project_ended)) : null,
            'project_location' => $this->project_location,
            'project_status' => $this->project_status,
            'project_description' => $this->project_description,
            'estimated_budget' => $this->estimated_budget,
        ]);
        // encoded type so I can loop json array 
        $type =  json_encode($this->project_type);
       //decoded to get each values and insert
        $service_types = json_decode($type,true);
       
        if($service_types){
            $project->services()->sync($service_types);

        }
            

      
        
        $this->updateMode = false;


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Project with ID: {$this->selected_id} successfully updated",
        ]);
        $this->resetInputFields();
    }
    }
    
    public function destroy(Project $project) {
        $project->delete();
    }
    
    public function createPDF()
    {
       $projects = Project::orderBy('id','desc')
        ->get();
        // $projects = Project::join('project_images','projects.id','=','project_images.project_id');
        view()->share('projects',$projects);
        
        $pdf = PDF::loadView('livewire.admin.project.project-pdf', compact('projects'))->setPaper('a4');
       $pdf->setOption('header-html', view('pdf.pdf-header'));
        return $pdf->stream('projects.pdf');
    }

}
