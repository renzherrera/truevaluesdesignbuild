<div>

   
       

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-2 card">
                <div class="card-body"><h5 class="card-title">New Service</h5>
                 
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="service_name" class="">Service Name</label>
                                    <input  wire:model.defer="service_name"  type="text" class="form-control" required>
                                    @error('position_title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                             
                           
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="job_description" class="">Service Description</label>
                                    <textarea wire:model.defer="service_description" style="  height:  40px;"  class="form-control" required></textarea>
                                    @error('job_description') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                            
                        </div>
                         <button wire:click.prevent="store()" class=" btn btn-info px-3 py-2  float-right">Create new Service</button>
                        <button wire:click.prevent="back()" class=" btn btn-warning px-5 py-2 mr-2 float-right">Back</button>

                </div>
            </div>

        </div>
        
    </div>
    

</div>