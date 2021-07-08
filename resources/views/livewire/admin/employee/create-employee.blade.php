<div>
    <style>
        .selectpicker{
            font-size: 0.9rem;
        }
        
    </style>
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card card pb-3 mb-2">
            <div class="card-body"><h5 class="card-title">Personal Information</h5>
                    <label for="exampleEmail11" class="mt-2">Photo</label>

                    <div class="form-row mb-3">
                        <div class="col-md-1 mr-5 mb-3 " >
                            <div id="profileCamera" class="mx-auto " style="height: 130px; width: 130px; background-color: #cfcfcf; border-radius:5%;  z-index-3">
                                @if ($image)
                                <img style="display:block; text-align:center; position: absolute;
                                top: 50%; transform: translateY(-50%);   margin: auto;
                                width: 130px;  z-index: 0;" src=" {{  $image->temporaryUrl()}}" alt="">
                           
                                @endif
                                <div class="text-center" wire:loading>Uploading...</div>

                             </div>
                        </div>
                        <div class="col-lg-2 align-self-center">
                            <div class="d-flex flex-column  ">
                                <button type="button" class="btn btn-info px-5 mb-3" data-toggle="modal" data-target="#createWebcam" data-backdrop="static" data-keyboard="false" onclick="configure()">Take a Photo</button>
                                <label for="image" class="btn btn-secondary px-5">Select a Photo</label>
                                <input type="file" name="image" id="image" wire:model.defer="image" hidden >
                            </div>
                        </div>


                    </div>
                    <div class="divider"></div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="first_name" class="">First Name</label>
                                <input name="first_name" id="first_name" wire:model.defer="first_name"  type="text" class="form-control" required>
                               @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="middle_name" class="">Middle Name</label>
                                <input name="middle_name" id="middle_name" wire:model.defer="middle_name"  type="text" class="form-control" required>
                               @error('middle_name') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="last_name" class="">Last Name</label>
                                <input name="last_name" id="last_name" wire:model.defer="last_name" type="text" class="form-control" required>
                               @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                    </div>
                   
                        
                     
                    <div class="form-row">
                        <div class="col-md-2">
                            <div class="position-relative form-group">
                                <label for="contact" class="">Contact no.</label>
                                <input name="contact" id="contact" wire:model.defer="contact" type="text" class="form-control"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                @error('contact') <span class="text-danger">{{ $message }}</span> @enderror
                            
                            </div>
                        </div>
                      
                        <div class="col-md-2">
                            <div class="position-relative form-group">
                                <label for="date_of_birth" class="">Date of Birth</label>
                                <input name="date_of_birth" id="date_of_birth" wire:model.defer="date_of_birth" type="date" class="form-control" required>
                               @error('date_of_birth') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="position-relative form-group">
                               <label for="gender" class="">Gender</label>
                               <select class="form-control selectpicker" wire:model.defer="gender" name="gender" id="gender" required>
                                   <option value="">-- Select gender --</option>
                                   <option value="male">Male</option>
                                   <option value="female">Female</option>
                               </select>
                               @error('gender') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="position-relative form-group">
                               <label for="status" class="">Status</label>
                               <select class="form-control selectpicker" wire:model.defer="status"   name="status" id="status" required>
                                <option value=""   >-- Select employee status --</option>
                                   <option value="1">Active</option>
                                   <option value="0">Inactive</option>
                               </select>
                               @error('status') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="position-relative form-group">
                                <label for="biometric_id" class="">Biometric ID</label>
                                <input  id="biometric_id" wire:model.defer="biometric_id" type="text" class="form-control">
                               @error('biometric_id') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="position-relative form-group">
                                <label for="card_number" class="">Bank / Card Number</label>
                                <input  id="card_number" wire:model.defer="card_number" type="text" class="form-control" required>
                               @error('card_number') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                       
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="position" class="">Position</label>
                                <select  name="position" id="position_select" wire:model.defer ="position_id" class="form-control selectpicker" title="Select Position" required> 
                                    <option value="" >-- Select Position</option>
                                    @foreach ($positions as $position)
                                    <option value="{{$position->id}}">{{ucfirst($position->position_title)}}</option>
                                        
                                    @endforeach
                                   
                                </select>
                               @error('position_id') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="schedule_id" >Schedule</label>
                                        <select id="schedule_id" type="text"  wire:model.defer="schedule_id"  class="form-control selectpicker" title="Select Schedule" required>
                                            <option>-- Select Schedule --</option>
                                         
                                            @foreach ($schedules as $schedule)
                                        
                                            <option value="{{$schedule->id}}">{{\Carbon\Carbon::parse($schedule->start_time)->format('h:i A')}} - {{\Carbon\Carbon::parse($schedule->end_time)->format('h:i A')}}</option>
                                                
                                            @endforeach
                                        </select>
                               @error('schedule_id') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="project_id" class="">Designated to</label>
                                        <select  name="project_id" id="project_id" wire:model.defer="project_id"  type="text" class="form-control selectpicker" required> 
                                            <option value="" >-- Select Designated Project --</option>
                                            @foreach ($projects as $project)
                                            <option value="{{$project->id}}"> {{ucfirst($project->project_name)}}</option>
                                                
                                            @endforeach
                                          
                                        </select>
                               @error('project_id') <span class="text-danger">{{ $message }}</span> @enderror

                                    </div>
                            </div>
                         
                </div>


                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="address" class="">Complete Address</label>
                                <textarea wire:model.defer="address" id="address" placeholder="1234 Main St. Subdivision, City of Example, Province." type="text" class="form-control"required></textarea>
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                           
                            </div>
                        </div>
                    </div>

                   

                        
            </div>
        </div>
        <button class="btn btn-primary px-5 py-2 mb-5 float-right" wire:click="store()">Save Details</button>
        <button class="btn btn-warning px-5 py-2 mb-5 mr-3 float-right" wire:click="listMode()">Back to Employee List</button>

    </div>
          
    
    </div>
</div>

