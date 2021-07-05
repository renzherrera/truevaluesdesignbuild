<?php

namespace App\Http\Livewire\Admin\Employee;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Project;
use App\Models\Schedule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListEmployee extends Component
{
    public $captured_image ,$image,$first_name,$middle_name,$last_name,$contact,$date_of_birth,$gender,$status,$schedule_id,$project_id, $position_id,$address;
    use WithFileUploads;
    public function render()
    {
        $positions = Position::select('id','position_title','salary_rate')->get();
        $schedules = Schedule::select('id','start_time','end_time')->get();
        $projects = Project::select('id','project_name')->get();
        return view('livewire.admin.employee.list-employee',compact('positions','projects','schedules'))->layout('layouts.master');
    }

    public function store()
    {

        $this->validate([
            'first_name' => 'required',
            'middle_name' => 'required',      
            'last_name' => 'required',
            'contact' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'position_id' => 'required',
            'schedule_id' => 'required',
            'project_id' => 'required',
            'address' => 'required',
            'status' => 'required',
        ]); 

        if($this->captured_image){
            $image = $this->captured_image; // image base64 encoded
            preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
            $image = str_replace(' ', '+', $image);
            $imageName = md5($this->captured_image . microtime()). '.' . $image_extension[1]; //generating unique file name;

            // store images from webcam in a folder
            \File::put(public_path(). '/storage/user_images/' .$imageName,base64_decode($image));
        }elseif($this->image){
            
            $imageName = md5($this->image . microtime()).'.'.$this->image->extension();

            // store images from input files in a folder
            $this->image->storeAs('user_images', $imageName ,  'public');
            
        }else{
            $imageName = null;
        }

         Employee::create([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'contact' => $this->contact,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'position_id' => $this->position_id,
            'schedule_id' => $this->schedule_id,
            'project_id' => $this->project_id,
            'address' => $this->address,
            'status' => $this->status,
            'image' => $imageName,
            // 'project_ended' => $this->project_ended !== null ? date('Y-m-d H:i:s', strtotime($this->project_ended)) : null,
        ]);
        $this->resetInputFields();
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Employee Added",
        ]);

    }

    public function resetInputFields()
    {
        $this->first_name='';
        $this->middle_name='';
        $this->last_name='';
        $this->contact= '';
        $this->date_of_birth=null;
        $this->gender='';
        $this->position_id='';
        $this->schedule_id='';
        $this->project_id='';
        $this->address='';
        $this->status='';

    
    }
}
