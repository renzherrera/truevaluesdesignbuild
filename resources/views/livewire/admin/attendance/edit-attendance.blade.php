<div>

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Edit Attendance</h5>
                    <input wire:model.defer="selected_id"  type="text"  class="form-control" hidden readonly/>
                    
                        <div class="form-row">
                            <div class="col-md-2">
                                <div class="position-relative form-group">
                                    <label for="biometric_id" class="">Employee</label>
                                    <select class="form-control" wire:model.defer="biometric_id" required>
                                        <option>-- Select Employee --</option>
                                        @foreach ($employees as $employee)
                                        <option value="{{$employee->biometric_id}}">{{$employee->first_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('biometric_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="attendance_date" class="">Attendance Date</label>
                                    <input  wire:model.defer="attendance_date"  type="date" class="form-control" required>
                                    @error('attendance_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="first_onDuty" class="">Time-in<small>(Regular)</small></label>
                                    <input  wire:model.defer="first_onDuty"  type="time"   min="06:00" max="17:00" class="form-control" required>
                                    @error('first_onDuty') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="first_offDuty" class="">Time-out<small>(Regular)</small></label>
                                    <input wire:model.defer="first_offDuty"  type="time"   min="17:00" max="24:00" class="form-control">
                                    @error('first_offDuty') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="second_onDuty" class="">Time-in<small>(Overtime)</small></label>
                                    <input wire:model.defer="second_onDuty"  type="time"   min="06:00" max="17:00" class="form-control">
                                    @error('second_onDuty') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="second_offDuty" class="">Time-out<small>(Overtime)</small></label>
                                    <input wire:model.defer="second_offDuty"  type="time"   min="17:00" max="24:00" class="form-control">
                                    @error('second_offDuty') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                        </div>
                        <div wire:loading.remove>

                         <button wire:click.prevent="update()" class=" btn btn-primary px-5 py-2  float-right">Save Record Changes</button>
                         <button wire:click.prevent="createMode()" class=" btn btn-warning px-5 py-2 mr-3 float-right">Back</button>

                        </div>
                </div>
            </div>

        </div>
        
    </div>
    



</div>