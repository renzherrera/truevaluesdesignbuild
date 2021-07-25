<div>
    <title>Register User | True Values</title>

    @include('livewire.admin.user.webcam-user')

    <style>
        .selectpicker{
            font-size: 0.9rem;
        }
        
    </style>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon bg-info">
                        <i class="pe-7s-add-user  text-white">
                        </i>
                    </div>
                    <div>Register User
                        <div class="page-title-subheading">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Non, aliquid.
                        </div>
                    </div>
                </div>
            </div>
        </div>        
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="main-card card pb-3 mb-3">
                        <div class="card-body"><h5 class="card-title">Personal Information</h5>
                            <div class="col-md-12 pb-5 ">
                                <label for="exampleEmail11" class="mt-2">Photo</label>
                                <div class="form-row mb-3">
                                    <div class="col-md-1 mr-5 mb-3 " >
                                        <div id="profileCamera" class="mx-auto " style="height: 130px; width: 130px; background-color: #cfcfcf; border-radius:5%;  z-index-3">
                                            @if ($image)
                                            <img style="display:block; text-align:center; position: absolute;
                                            top: 50%; transform: translateY(-50%);   margin: auto;
                                            width: 130px;  z-index: 0;" src=" {{  $image->temporaryUrl()}}" alt="">
                                    
                                            @endif
                                            <div class="text-center" wire:loading wire:target="image">Uploading...</div>

                                        </div>
                                    </div>
                                    <div class="col-lg-2 align-self-center">
                                        <div class="d-flex flex-column  ">
                                            <button type="button" class="btn btn-info px-5 mb-3" data-toggle="modal" data-target="#Webcam" data-backdrop="static" data-keyboard="false" onclick="configure()">Take a Photo</button>
                                            <label for="image" class="btn btn-secondary px-5">Select a Photo</label>
                                            <input type="file" name="image" id="image" wire:model.defer="image" hidden >
                                        </div>
                                    </div>


                                </div>
                                <div class="divider"></div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="name" class="">Name</label>
                                            <input wire:model.defer="name"  type="text" class="form-control" required>
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="email" class="">Email</label>
                                            <input wire:model.defer="email"  type="email" class="form-control" required>
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="password" class="">Password</label>
                                            <input wire:model.defer="password"  type="password" class="form-control" required>
                                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="role" class="">Role</label>
                                            <select name="role" id="position_select" wire:model.defer ="role" class="form-control selectpicker" title="Select Role" required> 
                                                <option><span class="text-muted">-- Select Role -- </span> </option>
                                                <option value="admin">Admin</option>
                                                <option value="admin">Encoder</option>
                                                @if (auth()->user()->role == "superadmin")
                                                <option value="superadmin">Super Admin</option>
                                                @endif
                                            </select>
                                        @error('role') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                </div>
                            
                                    
                                
                                    
                                
                                
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                        <label for="status" class="">Status</label>
                                        <select class="form-control selectpicker" wire:model.defer="status"   name="status" id="status" required>
                                            <option><span class="text-mute">-- Select employee status -- </span></option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>
                                    
                                    
                                
                                </div>

                            
                                    
                            </div>

                            
                            

                            </div>        
                        </div>
                    </div>
                    <a class="btn btn-primary px-5 py-2 mb-5 float-right text-white" wire:click="store()">Save Details</a>
                    <a class="btn btn-warning px-5 py-2 mb-5 mr-3 float-right" href="{{route('admin.list-users')}}" >Back to Users List</a>

                </div>
                
            </div>
</div>

