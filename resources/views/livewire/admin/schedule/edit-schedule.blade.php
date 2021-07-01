<div>

   
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-note text-warning">
                    </i>
                </div>
                <div>Edit Schedules
                    <div class="page-title-subheading">All fields are required to fill.
                    </div>
                </div>
            </div>
        </div>
    </div>           

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Edit Schedules Details</h5>
                  
                        <input name="selected_id" id="selected_id" wire:model="selected_id"  type="text" class="form-control" hidden readonly>

                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="schedule_title" class="">Schedule Title</label>
                                    <input name="schedule_title" id="schedule_title" wire:model="schedule_title"  type="text" class="form-control" required>
                                    @error('schedule_title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                             
                           
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="job_description" class="">Start Time</label>
                                    <input wire:model="start_time" type="time"  name="start_time" id="start_time"  class="form-control" required/>
                                    @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="end_time" class="">End Time</label>
                                    <input class="form-control " wire:model="end_time"  type="time"  required/>
                                    @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                               
                                </div>
                            </div>
                        </div>
                            <div class="float-right">
                                <button wire:click.prevent="back()" class=" btn btn-warning px-5 py-2 ">Cancel</button>
                                <button wire:click.prevent="update()" class=" btn btn-primary px-5 py-2  ">Save changes</button>
                            </div>
                        
                       
                    {{-- </form> --}}




                </div>
            </div>

        </div>
        
    </div>
    





</div>