<div>

   
       

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-2 card">
                <div class="card-body"><h5 class="card-title">Edit Service</h5>
                    <input name="selected_id" id="selected_id" wire:model="selected_id"  type="text" class="form-control" hidden readonly>
                 
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="service_name" class="">Service Name</label>
                                    <input name="service_name" id="service_name" wire:model="service_name"  type="text" class="form-control" required>
                                    @error('position_title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                             
                           
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="job_description" class="">Service Description</label>
                                    <textarea wire:model="service_description" style="  height:  40px;" name="service_description" id="service_description"  class="form-control" required></textarea>
                                    @error('job_description') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                            
                        </div>
                        <button wire:click.prevent="update()" class=" btn btn-info px-5 py-2  float-right">Save changes</button>

                        <button wire:click.prevent="back()" class=" btn btn-warning px-5 py-2 mr-2 float-right">Back</button>
                </div>
            </div>

        </div>
        
    </div>
    

</div>