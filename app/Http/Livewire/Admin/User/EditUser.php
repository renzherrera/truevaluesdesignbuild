<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditUser extends Component
{
    use WithFileUploads;
    public $image, $name, $email, $role, $status,$captured_image, $selected_id, $updated_image, $updated_captured_image;
    public function mount(int $user)
    {
        $user = User::find($user);
        $this->image = $user->image;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->status = $user->status;
        $this->selected_id = $user->id;
    }
    public function render()

    {
        return view('livewire.admin.user.edit-user')->layout('layouts.master');
    }

    public function update() {
        $this->validate([
            'name' => 'required',
            'email' => 'required',      
            'role' => 'required',
            
        ]); 
        if($this->updated_captured_image){
            $updated_image = $this->updated_captured_image; // image base64 encoded
            preg_match("/data:image\/(.*?);/",$updated_image,$image_extension); // extract the image extension
            $updated_image = preg_replace('/data:image\/(.*?);base64,/','',$updated_image); // remove the type part
            $updated_image = str_replace(' ', '+', $updated_image);
            $imageName = md5($this->updated_captured_image . microtime()). '.' . $image_extension[1]; //generating unique file name;

            Storage::disk('public')->put('user_images/'.$imageName, base64_decode($updated_image));
            // \File::put(public_path(). '/storage/employee_images/' .$imageName,base64_decode($image));

            // store images from webcam in a folder
            // $this->image->storeAs('employee_images', $imageName ,  'public');
            // Storage::disk('public')->put('storage/employee_images/',$imageName, base64_decode($image));
        }elseif($this->updated_image){
            
            $imageName = md5($this->updated_image . microtime()).'.'.$this->updated_image->extension();

            // store images from input files in a folder
            $this->updated_image->storeAs('user_images', $imageName ,  'public');
            
        }elseif(!$this->updated_image && !$this->updated_captured_image && $this->image){
            $imageName = $this->image;
        }else{
            $imageName = null;
        }

    if ($this->selected_id) {
        $user = User::find($this->selected_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
            'image' => $imageName,
        ]);
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Project with ID: {$this->selected_id} successfully updated",
        ]);
    }

    }

    public function nullImage() {
        $this->image = null ;
    }

}
