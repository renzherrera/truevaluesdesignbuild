<div>

   
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-paper-plane text-success">
                    </i>
                </div>
                <div>Projects
                    <div class="page-title-subheading">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde labore eaque blanditiis officia quia nulla..
                    </div>
                </div>
            </div>
        </div>
    </div>           

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-2 card">
                <div class="card-body m-3"><h5 class="card-title ">New Projects</h5>
                    {{-- <form action="{{route('admin.positions.store')}}" method="POST"> --}}
                        {{-- @csrf --}}
                        {{-- <div class="form-row">
                            <input type="file" name="" id="">
                        </div> --}}
                        <div class="form-row container-fluid">
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="project_name" class="">Project Name</label>
                                    <input name="project_name" wire:model="project_name"  type="text" class="form-control" required>
                                    @error('project_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                             
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="project_owner" >Project Owner</label>
                                    <input name="project_owner"  wire:model="project_owner"  type="text" class="form-control" required>
                                    @error('project_owner') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                          
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="estimated_budget" class="">Estimated Budget</label>
                                    <input class="form-control currency" wire:model="estimated_budget"  type="number" step='0.01' value='0.00' name="estimated_budget" placeholder='0.00' />
                                    @error('estimated_budget') <span class="text-danger">{{ $message }}</span> @enderror
                               
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_started" class="">Start Date</label>
                                    <input name="project_started" id="project_started" wire:model="project_started"  type="date" class="form-control">
                                    @error('project_started') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_ended" class="">End Date</label>
                                    <input name="project_ended" id="project_ended" wire:model="project_ended"  type="date" class="form-control">
                                    @error('project_ended') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="project_type" class="">Service Type</label>
                                    <select name="project_type" id="project_type" wire:model="project_type"  type="text" class="form-control" required>
                                        <option value="">-- Select service</option>
                                        <option value="1">Renovation</option>
                                        <option value="2">Build</option>
                                        <option value="3">Design</option>
                                        <option value="4">Design & Build</option>
                                    </select>
                                    @error('project_type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_location" class="">Location</label>
                                    <input name="project_location" id="project_location" wire:model="project_location"  type="text" class="form-control" >
                                    @error('project_location') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> <div class="col-md-3">
                                <div class="form-group">
                                    <label for="project_status" class="">Status</label>
                                    <select name="project_status" id="project_status" wire:model="project_status"  type="text" class="form-control" required>
                                        <option value="">-- Select status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Pending</option>
                                        <option value="3">Stopped</option>
                                        <option value="4">Completed</option>
                                    </select>
                                    @error('project_status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="position-relative form-group">
                                    <label for="project_description" class="">Project Description</label>
                                    <textarea wire:model="project_description"  name="project_description" id="project_description"  class="form-control" > </textarea>
                                    @error('project_description') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                        </div>

                         <button wire:click.prevent="store()" class=" btn btn-info px-5 py-2  float-right">Create Project</button>
                       
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