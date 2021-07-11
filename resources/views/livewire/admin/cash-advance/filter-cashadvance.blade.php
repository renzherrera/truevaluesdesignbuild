<div>
        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Filter</h5>

                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employee_id" class="">Employee</label>
                                    <select name="employee_id" id="employee_id" wire:model.defer="employee_id"  type="text" class="form-control" required>
                                        <option>-- Select Employee --</option>
                                        @foreach ($employees as $employee)
                                          <option value="{{$employee->id}}">{{ucwords($employee->first_name) .' ' . ucwords($employee->middle_name).' ' . ucwords($employee->last_name)}}</option>    
                                        @endforeach
                                    </select>
                                    @error('employee_id') <span class="text-danger">Employee field is required, please choose one Employee.</span> @enderror
                                </div>
                            </div>
                             
                           
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="cash_amount" class="">Amount in Peso</label>
                                    <input class="form-control " wire:model.defer="cash_amount"  type="number" step='0.01' value='0.00' id="cash_amount"  placeholder='0.00' required/>
                                    @error('cash_amount') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="requested_date" class="">Requested Date</label>
                                    <input class="form-control " wire:model.defer="requested_date"  type="date"  id="requested_date"  required/>
                                    @error('requested_date') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                            
                        </div>
                         <button wire:click.prevent="store()" class=" btn btn-warning px-5 py-2  float-right">Request for Cash Advance</button>

                </div>
            </div>

        </div>
        
    </div>
    



</div>