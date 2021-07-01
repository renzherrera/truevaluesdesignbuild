<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

class NewEmployee extends Component
{
    public $captured_image ,$input_photo;
    use WithFileUploads;
    public function render()
    {
        return view('livewire.admin.new-employee')->layout('layouts.master');
    }
}
