<div>

   
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-note text-warning">
                    </i>
                </div>
                <div>Edit Position
                    <div class="page-title-subheading">All fields are required to fill.
                    </div>
                </div>
            </div>
        </div>
    </div>           

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Edit Position Details</h5>
                    {{-- <form action="{{route('admin.positions.store')}}" method="POST"> --}}
                        {{-- @csrf --}}
                        <input name="selected_id" id="selected_id" wire:model="selected_id"  type="text" class="form-control" hidden readonly>

                        <div class="form-row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="position_title" class="">Position Title</label>
                                    <input name="position_title" id="position_title" wire:model="position_title"  type="text" class="form-control" required>
                                </div>
                            </div>
                             
                           
                            <div class="col-md-8">
                                <div class="position-relative form-group">
                                    <label for="job_description" class="">Job Description</label>
                                    <input wire:model="job_description"  name="job_description" id="job_description"  class="form-control" required/>
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <div class="position-relative form-group">
                                    <label for="salary_rate" class="">Salary Rate</label>
                                    <input class="form-control currency" wire:model="salary_rate"  type="number" step='0.01' value='0.00' id="salary_rate" name="salary_rate" placeholder='0.00' required/>
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