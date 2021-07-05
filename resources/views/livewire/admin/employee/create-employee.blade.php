<div>
    <style>
        .selectpicker{
            font-size: 0.9rem;
        }
        .modal-backdrop {
            /* bug fix - no overlay */    
            display: none;    
        }
        .modal {
            top:20%;

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
                                <button type="button" class="btn btn-info px-5 mb-3" data-toggle="modal" data-target=".bd-example-modal-sm" data-backdrop="static" data-keyboard="false" onclick="configure()">Take a Photo</button>
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
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="contact" class="">Contact no.</label>
                                <input name="contact" id="contact" wire:model.defer="contact" type="text" class="form-control"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                @error('contact') <span class="text-danger">{{ $message }}</span> @enderror
                            
                            </div>
                        </div>
                      
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="date_of_birth" class="">Date of Birth</label>
                                <input name="date_of_birth" id="date_of_birth" wire:model.defer="date_of_birth" type="date" class="form-control" required>
                               @error('date_of_birth') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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

    </div>
          
    
    </div>

    
{{-- CAMERA MODAL  --}}
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="webcam_modal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Camera</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="offCam()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-auto">
                <div id="webcam-div"></div>
            </div>
            <div class="modal-footer" style="margin-top: -15px;">
                <button id="retake_btn" type="button" class="btn btn-secondary" onclick="cameraUnfreeze()">Retake</button>
                <button id="capture_btn" type="button" class="btn btn-warning" onclick="preview_snapshot()">Capture</button>
                <button id="save_btn" type="button" class="btn btn-primary"  onclick="saveSnapshot()" data-dismiss="modal" onclick="offCam()">Save changes</button>
       
                <input type="hidden" name="captured_image" id="input_webcam" class="image-tag" wire:model.defer="captured_image">
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="{{asset('assets/scripts/webcamjs-master/webcam.js')}}"></script>
<script language="JavaScript">
 function configure(){

        Webcam.set({
        width: 280,
        height: 210,
        crop_width:210,
        crop_height:210,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach( '#webcam-div' );
    document.getElementById('capture_btn').style.display = '';
    document.getElementById('save_btn').style.display = 'none';
    document.getElementById('retake_btn').style.display = 'none';
} 

    function offCam()
    {
        Webcam.reset();

    }
    function preview_snapshot() {
       // freeze camera so user can preview pic
       Webcam.freeze();
            
            // swap button sets
            document.getElementById('capture_btn').style.display = 'none';
            document.getElementById('save_btn').style.display = '';
            document.getElementById('retake_btn').style.display = '';
    }
    function saveSnapshot() {
    // take snapshot and get image data
    Webcam.snap( function(data_uri) {
    // display results in input webcam
    $(".image-tag").val(data_uri);
    document.getElementById('profileCamera').innerHTML = 
    '<img id="imageprev" class="" src="'+data_uri+'" style="height: 130px; width: 130px; background-color: #cfcfcf; border-radius:5%; "/>  ';
    //update databind livewire below
    var element = document.getElementById('input_webcam');
    element.dispatchEvent(new Event('input'));
    } );
    Webcam.reset();


    }
    
    function cameraUnfreeze() {
        Webcam.unfreeze()
        document.getElementById('capture_btn').style.display = '';
        document.getElementById('save_btn').style.display = 'none';
        document.getElementById('retake_btn').style.display = 'none';

    }
</script>