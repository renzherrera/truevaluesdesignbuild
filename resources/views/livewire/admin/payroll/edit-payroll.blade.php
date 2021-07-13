<div>

   
    

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Edit Payroll</h5>
                        <div class="form-row">
                            <input name="selected_id" id="selected_id" wire:model.defer="selected_id"  type="text" class="form-control"  readonly hidden>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="position_title" class="">From<small>(Start Date)</small></label>
                                    <input name="position_title" id="position_title" wire:model.defer="payroll_from_date"  type="date" class="form-control" required>
                                    @error('position_title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div><div class="col-md-2">
                                <div class="form-group">
                                    <label for="payroll_to_date" class="">To<small>(End Date)</small></label>
                                    <input wire:model.defer="payroll_to_date"  type="date" class="form-control" required>
                                    @error('position_title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="position-relative form-group">
                                    <label for="job_description" class="">Payroll Description</label>
                                    <input wire:model.defer="payroll_description"  name="job_description" id="payroll_description"  class="form-control" required/>
                                    @error('job_description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            
                        </div>
                         <button wire:click.prevent="update()" class=" btn btn-primary px-5 py-2  float-right">Save changes</button>
                         <button wire:click.prevent="createMode()" class=" btn btn-secondary px-3 py-2 mr-3  float-right">Back to Create Mode</button>
                </div>
            </div>

        </div>
        
    </div>
    



</div>