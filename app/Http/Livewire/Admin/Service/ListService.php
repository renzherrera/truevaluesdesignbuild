<?php

namespace App\Http\Livewire\Admin\Service;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
class ListService extends Component
{
    public $updateMode = false, $createMode = false, $listMode = false,
    $service_description, $service_name, $searchTerm,$selected_id;
    use WithPagination;
    public function render()
    {
        $searchTerm='%'.$this->searchTerm . '%';
        $services = Service::where('service_name', 'LIKE', $searchTerm)
                    ->orWhere('service_description','LIKE', $searchTerm)
                    ->paginate(5);
        return view('livewire.admin.service.list-service',compact('services'))->layout('layouts.master');
    }

    public function store()
    {
        $this->validate([
            'service_name' => 'required',
            'service_description' => 'required',
        ]); 
        Service::create([
            'service_name' => $this->service_name,
            'service_description' => $this->service_description,

        ]);


        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Service Added",
        ]);

       $this->resetFields();
    //   return redirect()->route('admin.positions.create');  

    }
    public function edit($id)
    {
        $this->updateMode = true;
        $this->listMode = false;
        $this->createMode = false;

        $service = Service::findOrFail($id);
        $this->selected_id = $id;
        $this->service_name = $service->service_name;
        $this->service_description = $service->service_description;
    }
    public function update() {
        $this->validate([
            'service_name' => 'required',
            'service_description' => 'required',
        ]); 
    if ($this->selected_id) {
        $schedule = Service::find($this->selected_id);
        $schedule->update([
            'service_name' => $this->service_name,
            'service_description' => $this->service_description,
        ]);
        $this->updateMode = false;
        $this->listMode = true;
        $this->createMode = false;

        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Service with ID: {$this->selected_id} successfully updated",
        ]);
        $this->resetFields();
    }
    }

    public function destroy(Service $service) {
        $service->delete();
}

    public function back() {
        $this->updateMode = false;
        $this->listMode = true;
        $this->createMode = false;
        $this->resetFields();
    }
    
    public function resetFields() {
        $this->service_name = '';
        $this->service_description = '';
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

}
