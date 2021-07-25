<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\CompanyProfile as ModelsCompanyProfile;
use App\Models\Profile;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanyProfile extends Component
{
    use WithFileUploads;
    public $updateMode = false,$company_name,$nature_of_business,$contact_number,$email_address, $office_address,$about_company,$facebook,$instagram,$twitter,$image,$updated_image;
    public function mount() {
        $company = Profile::first();
        if($company){
        $this->company_name = $company->company_name;
        $this->nature_of_business = $company->nature_of_business;
        $this->contact_number = $company->contact_number;
        $this->email_address = $company->email_address;
        $this->office_address = $company->office_address;
        $this->about_company = $company->about_company;
        $this->facebook = $company->facebook;
        $this->instagram = $company->instagram;
        $this->twitter = $company->twitter;
        $this->image = $company->image;
    }
    
    }
    public function render()
    {
        $company = Profile::first();
        if($company){

            $this->company_name = $company->company_name;
            $this->nature_of_business = $company->nature_of_business;
            $this->contact_number = $company->contact_number;
            $this->email_address = $company->email_address;
            $this->office_address = $company->office_address;
            $this->about_company = $company->about_company;
            $this->facebook = $company->facebook;
            $this->instagram = $company->instagram;
            $this->twitter = $company->twitter;
            $this->image = $company->image;
        }

        
        return view('livewire.admin.company.company-profile',compact('company'))->layout('layouts.master');

    }

    public function updateMode() {
        $this->updateMode = true;
    }

    public function update() {
        $this->validate([
            'company_name' => 'required',
            'email_address' => 'required',
            'contact_number' => 'required',
            'office_address' => 'required',
            'about_company' => 'required',
        ]); 

        $company = Profile::first();


        if($this->updated_image){
            
            $imageName = md5($this->updated_image . microtime()).'.'.$this->updated_image->extension();

            // store images from input files in a folder
            $this->updated_image->storeAs('images', $imageName ,  'public');

            if($this->image && $company){
            unlink("storage/images/".$company->image);
        }


            
        }elseif(!$this->updated_image && $this->image){
            $imageName = $this->image;
        }else{
            $imageName = null;
            if($company->image){
            unlink("storage/images/".$company->image);
             }
        }


        if(!$company){
             Profile::create([
            'company_name' => $this->company_name,
            'email_address' => $this->email_address,
            'contact_number' => $this->contact_number,
            'office_address' => $this->office_address,
            'about_company' => $this->about_company,
            'nature_of_business' => $this->nature_of_business,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'image' => $imageName,
        ]);
        $this->updateMode = false;

        if($company){
        $this->image = $company->image;
        }

        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Company Profile successfully created",
        ]);
    }// end of checking company rows
    else {
        $company->update([
            'company_name' => $this->company_name,
            'email_address' => $this->email_address,
            'contact_number' => $this->contact_number,
            'office_address' => $this->office_address,
            'about_company' => $this->about_company,
            'nature_of_business' => $this->nature_of_business,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'image' => $imageName,
        ]);
        $this->updateMode = false;

        if($company){
        $this->image = $company->image;
        }

        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => 'Success!!',
            'text'  => "Company Profile successfully updated",
        ]);

    }
        $this->updated_image = null;
    }

    public function imageNull() {
        $this->image = null;
        $this->updated_image = null;
    }

    public function resetImage() {
        $company = Profile::first();
        $this->image = $company->image;
        $this->updated_image = null;

    }
}
