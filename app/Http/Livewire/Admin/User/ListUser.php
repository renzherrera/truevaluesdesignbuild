<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
class ListUser extends Component
{
    use WithPagination;
    public $searchTerm;
    public function render()
    {

        $searchTerm=$this->searchTerm;
        $users = User::orWhere('name', 'LIKE', "%{$searchTerm}%")
        ->orWhere('email', 'LIKE', "%{$searchTerm}%")
        ->paginate(8);
        return view('livewire.admin.user.list-user',compact('users'))->layout('layouts.master');
    }


    public function edit(User $user) {
        $user = User::get();
        return view('admin.livewire.user.edit',compact('user'));
    }
    
    public function destroy(User $user) {
        try{
            $user->delete();
            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => 'Success!!',
                'text'  => "Record of {$user->name} successfully deleted",
            ]);
            unlink("storage/user_images/".$user->image);

        }catch(Exception $ex){

            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => 'Error!!',
                'text'  => "Unable to delete {$user->first_name}.",
            ]);
        }
    }
}
