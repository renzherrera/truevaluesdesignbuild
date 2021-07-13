<div>

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">New Payroll</h5>
                        <div class="form-row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="payroll_from_date" class="">From<small>(Start Date)</small></label>
                                    <input  wire:model.defer="payroll_from_date"  type="date" class="form-control" required>
                                    @error('payroll_from_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div><div class="col-md-2">
                                <div class="form-group">
                                    <label for="payroll_to_date" class="">To<small>(End Date)</small></label>
                                    <input id  wire:model.defer="payroll_to_date"  type="date" class="form-control" required>
                                    @error('payroll_to_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="position-relative form-group">
                                    <label for="payroll_description" class="">Payroll Description</label>
                                    <input wire:model.defer="payroll_description"  name="job_description" id="payroll_description"  class="form-control" required/>
                                    @error('payroll_description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            
                        </div>
                         <button wire:click.prevent="store()" class=" btn btn-info px-5 py-2  float-right">Create new Payroll</button>
                </div>
            </div>

        </div>
        
    </div>
    



</div>