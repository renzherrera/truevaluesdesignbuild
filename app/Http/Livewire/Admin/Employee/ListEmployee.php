<?php

namespace App\Http\Livewire\Admin\Employee;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Project;
use App\Models\Schedule;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use PDF;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;

class ListEmployee extends Component
{
    public $captured_image ,$image,$first_name,$middle_name,$last_name, $selected_id,
    $contact,$date_of_birth,$gender,$status,$schedule_id,$project_id, $position_id,$address,$searchTerm,$updated_captured_image,$updated_image,
    $createMode = false, $listMode = true, $updateMode = false, $imageResetMode = false, $imageNullMode= false, $importExcelFile, $card_number, $biometric_id;
    use WithFileUploads;
    use WithPagination;
    public function render()
    {
        if($this->updated_captured_image){
            $this->imageResetMode = true;
            $this->imageNullMode = false;
            $this->image = null;
        }
        elseif($this->updated_image){
                $this->imageResetMode = true;
                $this->imageNullMode = false;
                $this->image = null;
                
        }elseif(!$this->image){
            $this->imageResetMode = false;
            $this->imageNullMode = false;
            

        }
        $positions = Position::select('id','position_title','salary_rate')->get();
        $schedules = Schedule::select('id','start_time','end_time')->get();
        $projects = Project::select('id','project_name')->get();

        $searchTerm=$this->searchTerm;
        $employees = Employee::with('position','project','schedule')
        ->orWhere(DB::raw('CONCAT(first_name, " ", middle_name," ",last_name)'), 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('first_name', 'LIKE', "%{$searchTerm}%")
        ->orWhere('middle_name', 'LIKE', "%{$searchTerm}%")
        ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
          ->paginate(5);
        return view('livewire.admin.employee.list-employee',compact('positions','projects','schedules','employees'))->layout('layouts.master');
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

            Storage::disk('public')->put('employee_images/'.$imageName, base64_decode($image));
            // \File::put(public_path(). '/storage/employee_images/' .$imageName,base64_decode($image));

            // store images from webcam in a folder
            // $this->image->storeAs('employee_images', $imageName ,  'public');
            // Storage::disk('public')->put('storage/employee_images/',$imageName, base64_decode($image));
        }elseif($this->image){
            
            $imageName = md5($this->image . microtime()).'.'.$this->image->extension();

            // store images from input files in a folder
            $this->image->storeAs('employee_images', $imageName ,  'public');
            
        }else{
            $imageName = null;
        }
        try {

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
            'card_number' => $this->card_number,
            'biometric_id' => $this->biometric_id,
            'image' => $imageName,
            // 'project_ended' => $this->project_ended !== null ? date('Y-m-d H:i:s', strtotime($this->project_ended)) : null,
        ]);
        $this->resetInputFields();
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New Employee Added",
        ]);
    } catch(Exception $ex) {
        $this->emit('swal:modal', [
            'icon'  => 'error',
            'title' => 'Failed!!',
            'text'  => "Employee Creation failed. {$ex->getMessage()}",
        ]);
    }

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
        $this->image='';
        $this->updated_captured_image='';
        $this->updated_image='';
        $this->biometric_id='';
        $this->card_number='';

    
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

        $employee = Employee::with('position','project','schedule')->findOrFail($id);
        $this->selected_id = $id;
        $this->image = $employee->image;
        $this->first_name = $employee->first_name;
        $this->middle_name = $employee->middle_name;
        $this->last_name= $employee->last_name;
        $this->contact= $employee->contact;
        $this->date_of_birth=$employee->date_of_birth;
        $this->gender=$employee->gender;
        $this->position_id=$employee->position_id;
        $this->schedule_id=$employee->schedule_id;
        $this->project_id=$employee->project_id;
        $this->address=$employee->address;
        $this->status=$employee->status;
        $this->biometric_id=$employee->biometric_id;
        $this->card_number=$employee->card_number;

        if($this->image){
            $this->imageNullMode = true;
        }

    }

    public function update() {
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
        if($this->updated_captured_image){
            $updated_image = $this->updated_captured_image; // image base64 encoded
            preg_match("/data:image\/(.*?);/",$updated_image,$image_extension); // extract the image extension
            $updated_image = preg_replace('/data:image\/(.*?);base64,/','',$updated_image); // remove the type part
            $updated_image = str_replace(' ', '+', $updated_image);
            $imageName = md5($this->updated_captured_image . microtime()). '.' . $image_extension[1]; //generating unique file name;

            Storage::disk('public')->put('employee_images/'.$imageName, base64_decode($updated_image));
            // \File::put(public_path(). '/storage/employee_images/' .$imageName,base64_decode($image));

            // store images from webcam in a folder
            // $this->image->storeAs('employee_images', $imageName ,  'public');
            // Storage::disk('public')->put('storage/employee_images/',$imageName, base64_decode($image));
        }elseif($this->updated_image){
            
            $imageName = md5($this->updated_image . microtime()).'.'.$this->updated_image->extension();

            // store images from input files in a folder
            $this->updated_image->storeAs('employee_images', $imageName ,  'public');
            
        }elseif(!$this->updated_image && !$this->updated_captured_image && $this->image){
            $imageName = $this->image;
        }else{
            $imageName = null;
        }


    if ($this->selected_id) {
        $employee = Employee::find($this->selected_id);
        $employee->update([
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
            'card_number' => $this->card_number,
            'biometric_id' => $this->biometric_id,
            'image' => $imageName,
        ]);
        $this->updateMode = false;
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Project with ID: {$this->selected_id} successfully updated",
        ]);
        $this->resetInputFields();
    }
    }


    public function destroy(Employee $employee) {
        try{
            $employee->delete();
            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => 'Success!!',
                'text'  => "{$employee->first_name} successfully deleted",
            ]);
            unlink("storage/employee_images/".$employee->image);

        }catch(Exception $ex){

            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Error!!',
                'text'  => "Unable to delete {$employee->first_name}.",
            ]);
        }
      
    }

    
    public function resetImage() {
        $this->imageNullMode = false;
        $this->imageResetMode = true;
        $this->updated_captured_image = null;
        $this->updated_image = null;

    }
    public function nullImage() {
        $this->image = null;
        $this->updated_image = null;
        $this->updated_captured_image = null;
        $this->imageNullMode = false;
        $this->imageResetMode = false;
    }

    public function originalImage() {
        $employee = Employee::find($this->selected_id);

        $this->image = $employee->image;
        $this->updated_image = null;
        $this->updated_captured_image = null;
        $this->imageNullMode = true;
        $this->imageResetMode = false;
    }

    public function createPDF()
    {
       $employees = Employee::select('first_name','middle_name','last_name','project_id','position_id','status','gender')->orderBy('project_id')
        ->get();
        // $projects = Project::join('project_images','projects.id','=','project_images.project_id');
        view()->share('employees',$employees);
        
        $pdf = PDF::loadView('livewire.admin.employee.employee-pdf', compact('employees'))->setPaper('a4');
       $pdf->setOption('header-html', view('pdf.pdf-header'));
        return $pdf->stream('employees.pdf');
    }

   
    // public function import(){
    //     Excel::import(new EmployeeImport, $this->importExcelFile);
    // }
}
