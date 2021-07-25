<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
class CreateUser extends Component
{
    public $image, $captured_image, $name, $email, $role, $status, $password;
    use WithFileUploads;
    public function render()
    {
        return view('livewire.admin.user.create-user')->layout('layouts.master');
    }

    public function store(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',      
            'password' => 'required',
            'role' => 'required',
            'status' => 'required',
        
        ]); 

        if($this->captured_image){
            $image = $this->captured_image; // image base64 encoded
            preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
            $image = str_replace(' ', '+', $image);
            $imageName = md5($this->captured_image . microtime()). '.' . $image_extension[1]; //generating unique file name;

            Storage::disk('public')->put('user_images/'.$imageName, base64_decode($image));
            // \File::put(public_path(). '/storage/employee_images/' .$imageName,base64_decode($image));

            // store images from webcam in a folder
            // $this->image->storeAs('employee_images', $imageName ,  'public');
            // Storage::disk('public')->put('storage/employee_images/',$imageName, base64_decode($image));
        }elseif($this->image){
            
            $imageName = md5($this->image . microtime()).'.'.$this->image->extension();

            // store images from input files in a folder
            $this->image->storeAs('user_images', $imageName ,  'public');
            
        }else{
            $imageName = null;
        }
        try {

         User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'status' => $this->status,
            'image' => $imageName,
            // 'project_ended' => $this->project_ended !== null ? date('Y-m-d H:i:s', strtotime($this->project_ended)) : null,
        ]);
        $this->resetInputFields();
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "New User Added",
        ]);
    } catch(Exception $ex) {
        $this->emit('swal:modal', [
            'icon'  => 'error',
            'title' => 'Failed!!',
            'text'  => "User Creation failed. {$ex->getMessage()}",
        ]);
    }
    }

    public function resetInputFields() {
        $this->name = '';
        $this-> email = '';
        $this->password = '';
        $this->role = null;
        $this->status = null;
        $this->image = null;
    }
    
}
