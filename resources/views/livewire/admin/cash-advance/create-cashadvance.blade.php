<div>

            

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">New Cash Advance</h5>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employee_id" class="">Employee</label>
                                    <select name="employee_id" id="employee_id" wire:model.defer="employee_id"  type="text" class="form-control" required>
                                        <option>-- Select Employee --</option>
                                        @foreach ($employees as $employee)
                                          <option value="{{$employee->id}}">{{ucwords($employee->first_name) .' ' . ucwords($employee->middle_name).' ' . ucwords($employee->last_name)}}</option>    
                                        @endforeach
                                    </select>
                                    @error('employee_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                             
                           
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="amount_cash" class="">Amount in Peso</label>
                                    <input class="form-control " wire:model.defer="amount_cash"  type="number" step='0.01' value='0.00' id="salary_rate" name="salary_rate" placeholder='0.00' required/>
                                    @error('amount_cash') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                            
                        </div>
                         <button wire:click.prevent="store()" class=" btn btn-info px-5 py-2  float-right">Create new Position</button>

                </div>
            </div>

        </div>
        
    </div>
    



</div>