<div>

   
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-paper-plane text-success">
                        </i>
                    </div>
                    <div>Positions
                        <div class="page-title-subheading">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde labore eaque blanditiis officia quia nulla..
                        </div>
                    </div>
                </div>
            </div>
        </div>           
    
            
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="card-title">New Position</h5>
                        {{-- <form action="{{route('admin.positions.store')}}" method="POST"> --}}
                            {{-- @csrf --}}
    
                            <div class="form-row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="position_title" class="">Position Title</label>
                                        <input name="position_title" id="position_title" wire:model.defer="position_title"  type="text" class="form-control" required>
                                        @error('position_title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                 
                               
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="job_description" class="">Job Description</label>
                                        <input wire:model.defer="job_description"  name="job_description" id="job_description"  class="form-control" required/>
                                        @error('job_description') <span class="text-danger">{{ $message }}</span> @enderror

                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="position-relative form-group">
                                        <label for="salary_rate" class="">Salary Rate</label>
                                        <input class="form-control currency" wire:model.defer="salary_rate"  type="number" step='0.01' value='0.00' id="salary_rate" name="salary_rate" placeholder='0.00' required/>
                                        @error('salary_rate') <span class="text-danger">{{ $message }}</span> @enderror
                                   
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative form-group">
                                        <label for="has_holiday" class="">With Holidays</label>
                                        <select class="form-control currency" wire:model.defer="has_holiday" required>
                                            <option>-- Choose Yes or No --</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        @error('has_holiday') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                             <button wire:click.prevent="store()" class=" btn btn-info px-5 py-2  float-right">Create new Position</button>
                           
                        {{-- </form> --}}

    
    
    
                    </div>
                </div>
    
            </div>
            
        </div>
        
    
   
    {{-- <script type="text/javascript">
        $(function () {
          
          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('admin.positions.index') }}",
              columns: [
                  {data: 'position_title', name: 'position_title'},
                  {data: 'job_description', name: 'job_description'},
                  {data: 'salary_rate', name: 'salary_rate'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
          
        });
      </script> --}}
    


    </div>