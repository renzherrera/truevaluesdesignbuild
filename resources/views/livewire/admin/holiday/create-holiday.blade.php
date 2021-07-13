<div>

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Create Holiday</h5>
                        <div class="form-row">
                            <div class="col-md-5">
                                <div class="position-relative form-group">
                                    <label for="holiday_name" class="">Holiday Title</label>
                                    <input wire:model.defer="holiday_name"  class="form-control" required/>
                                    @error('holiday_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            
                           
                            <div class="col-md-2">
                                <div class="position-relative form-group">
                                    <label for="rate" class="">Holiday Regular Rate <small>(In percentage)</small></label>
                                    <input class="form-control" wire:model.defer="rate"  type="number" step='0.01' value='0.00' placeholder='0.00' />
                                    @error('rate') <span class="text-danger">{{ $message }}</span> @enderror
                               
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="position-relative form-group">
                                    <label for="ot_rate" class="">Holiday Overtime Rate <small>(In percentage)</small></label>
                                    <input class="form-control " wire:model.defer="ot_rate"  type="number" step='0.01' value='0.00' placeholder='0.00' />
                                    @error('ot_rate') <span class="text-danger">{{ $message }}</span> @enderror
                               
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date" class="">Date</label>
                                    <input  wire:model.defer="date"  type="date" class="form-control" required>
                                    @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                           
                        </div>
                         <button wire:click.prevent="store()" class=" btn btn-primary px-5 py-2  float-right">Save New Holiday</button>
                </div>
            </div>

        </div>
        
    </div>
    



</div>