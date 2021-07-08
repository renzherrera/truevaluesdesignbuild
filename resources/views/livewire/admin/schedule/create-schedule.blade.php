<div>

   
          

        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">New Schedule</h5>
                    {{-- <form action="{{route('admin.positions.store')}}" method="POST"> --}}
                        {{-- @csrf --}}

                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="schedule_title" class="">Schedule Title</label>
                                    <input name="schedule_title" id="schedule_title" wire:model.defer="schedule_title"  type="text" class="form-control" required>
                                    @error('schedule_title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                             
                           
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="job_description" class="">Start Time</label>
                                    <input wire:model.defer="start_time" type="time"  name="start_time" id="start_time"  class="form-control" required/>
                                    @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="end_time" class="">End Time</label>
                                    <input class="form-control " wire:model.defer="end_time"  type="time"  required/>
                                    @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                               
                                </div>
                            </div>
                        </div>

                         <button wire:click.prevent="store()" class=" btn btn-info px-5 py-2  float-right">New Schedule</button>
                       
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