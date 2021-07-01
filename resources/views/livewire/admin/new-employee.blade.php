<title>New Employee | True Values</title>
</head>
<div>
   
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-graph text-success">
                        </i>
                    </div>
                    <div>New Employee
                        <div class="page-title-subheading">All fields are required to fill.
                        </div>
                    </div>
                </div>
            </div>
        </div>           
    
    
    
    
        
            
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="card-title">Personal Information</h5>
                        <form>
                            <label for="exampleEmail11" class="mt-2">Photo</label>
    
                            <div class="form-row mb-3">
                                <div class="col-md-1 m-5 mb-3 " >
                                    <div id="profileCamera" class="mx-auto " style="height: 130px; width: 130px; background-color: #cfcfcf; border-radius:5%; ">
                                        @if ($input_photo)
                                        <img style="display:block; text-align:center; position: relative;
                                        top: 50%; transform: translateY(-50%);   margin: auto;
                                        width: 130px; z-index: 999999999;" src=" {{  $input_photo->temporaryUrl()}}" alt="">
                                   
                                            
                                        @endif
                                     </div>
                                </div>
                                <div class="col-lg-2 align-self-center">
                                    <div class="d-flex flex-column  ">
                                        <button type="button" class="btn btn-primary px-5 mb-3" data-toggle="modal" data-target=".bd-example-modal-sm" data-backdrop="static" data-keyboard="false" onclick="configure()">Take a Photo</button>
                                        <label for="input_photo" class="btn btn-secondary px-5">Select a Photo</label>
                                        <input type="file" name="input_photo" id="input_photo" wire:model="input_photo" hidden >
                                    </div>
                                </div>
    
    
                            </div>
                            <div class="divider"></div>
    
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail11" class="">First Name</label>
                                        <input name="email" id="exampleEmail11"  type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="middle_name" class="">Middle Name</label>
                                        <input name="middle_name" id="middle_name" type="text" class="form-control" required>
                                    </div>
                                </div>  
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="last_name" class="">Last Name</label>
                                        <input name="last_name" id="last_name" type="text" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-11">
                                    <div class="position-relative form-group"><label for="exampleAddress" class="">Complete Address</label>
                                        <input name="address" id="address" placeholder="1234 Main St. Subdivision, City of Example, Province." type="text" class="form-control"required>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="position-relative form-group">
                                        <label for="gender" class="">Gender</label>
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="Male">Male</option>
                                            <option value="Male">Female</option>
                                        </select>
                                    </div>
                                </div>
                             
                            </div>
                   
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="position-relative form-group"><label for="contact" class="">Contact no.</label><input name="contact" id="contact" type="text" class="form-control"  onkeypress="return event.charCode >= 48 && event.charCode <= 57"></div>
                                </div>
                              
                                <div class="col-md-3">
                                    <div class="position-relative form-group">
                                        <label for="date_of_birth" class="">Date of Birth</label>
                                        <input name="date_of_birth" id="date_of_birth" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="position-relative form-group"><label for="position" class="">Position</label>
                                        <select  name="position" id="position" type="text" class="form-control"> 
                                            <option value="">-- Select Position</option>
                                            <option value="">Assistant</option>
                                            <option value="">Engineer</option>
                                            <option value="">Junior Architect</option>
                                            <option value="">Principal Architect</option>
                                            <option value="">Subcon</option>
                                            <option value="">Helper</option>
                                            <option value="">Driver</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="position-relative form-group">
                                        <label for="designated" class="">Designated to</label>
                                            <select  name="designated" id="designated" type="text" class="form-control"> 
                                                <option value="">-- Select Designated Project</option>
                                                <option value="">Project Bulacan</option>
                                                <option value="">Project La-union</option>
                                                <option value="">Project Baguio</option>
                                            </select>
                                        </div>
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="schedule" class="">Schedule</label>
                                            <select name="schedule" id="schedule" type="text" class="form-control" >
                                                <option value="">-- Select Schedule</option>
                                                <option value="">7:00:00 AM - 6:00:00 PM</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
    
    
    
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="card-title">Incase of Emergency</h5>
                        <div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="guardian_name" class="mr-sm-2">Guardian Name</label>
                                        <input name="guardian_name" id="guardian_name" placeholder="Enter a Complete Name (Last Name, First Name, Middle Initial)"    type="email"
                                        class="form-control"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="guardian_contact" class="mr-sm-2">Contact Number</label>
                                        <input name="guardian_contact" id="guardian_contact" placeholder="Enter a Phone Number" type="text" class="form-control"   onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    </div>
                                </div>
                              
                            </div>
                            <div class="divider"></div>
                            
                           
                        </div>
                        
                    </div>
    
                </div>
                <button class=" btn btn-primary px-5 py-2 mb-5 float-right">Save Details</button>
            </form>
    
            </div>
            
        </div>
        
    </div>
    
    
    
    
    
    
</div>
