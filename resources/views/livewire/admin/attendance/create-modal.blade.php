    

            <style>
                .modal-backdrop {
                    /* bug fix - no overlay */    
                    display: none;    
                }
                .modal {
                    top:20%;
        
                }
            </style>
            <div class="modal fade bd-example-modal-lg" id="attendance_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{!$updateMode ? 'Create New Record' : 'Edit Record'}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div wire:loading.remove>
                            <div class="modal-body">
                                <div class="card-body">
                                    <input wire:model.defer="selected_id"  type="text"  class="form-control" hidden readonly/>
                                    
                                        <div class="form-row">
                                            <div class="col-md-6">
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="attendance_date" class="">Attendance Date</label>
                                                    <input  wire:model.defer="attendance_date"  type="date" class="form-control" required>
                                                    @error('attendance_date') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <hr>
                                            <h5 class="card-title col-md-12">Regular</h5>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="first_onDuty" class="">Time-in<small>(Regular)</small></label>
                                                    <input  wire:model.defer="first_onDuty"  type="time"   min="06:00" max="17:00" class="form-control" required>
                                                    @error('first_onDuty') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="first_offDuty" class="">Time-out<small>(Regular)</small></label>
                                                    <input wire:model.defer="first_offDuty"  type="time"   min="17:00" max="24:00" class="form-control">
                                                    @error('first_offDuty') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <hr>
                                            <h5 class="card-title col-md-12">Overtime</h5>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="second_onDuty" class="">Time-in<small>(Overtime)</small></label>
                                                    <input wire:model.defer="second_onDuty"  type="time"   min="06:00" max="17:00" class="form-control">
                                                    @error('second_onDuty') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="second_offDuty" class="">Time-out<small>(Overtime)</small></label>
                                                    <input wire:model.defer="second_offDuty"  type="time"   min="17:00" max="24:00" class="form-control">
                                                    @error('second_offDuty') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            
                                        </div>
                                    
                                </div>
            
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div wire:loading.remove>
                                @if($updateMode)
                                    <button wire:click.prevent="update()" class=" btn btn-primary px-5 py-2  float-right">Save Changes</button>
                                @else
                                <button wire:click.prevent="store()" class=" btn btn-info px-5 py-2  float-right">New Record</button>
                                @endif
                                <button wire:click.prevent="createMode()"  data-dismiss="modal" class=" btn btn-warning px-5 py-2 mr-3 float-right">Back</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>