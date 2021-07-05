<div>
   
   
    
        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-2 card">
                <div class="card-body m-3"><h5 class="card-title ">New Projects</h5>
                    {{-- <form action="{{route('admin.positions.store')}}" method="POST"> --}}
                        {{-- @csrf --}}
                        {{-- <div class="form-row">
                            <input type="file" name="" id="">
                        </div> --}}
                        <div class="form-row container-fluid pb-4">
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="project_name" class="">Project Name</label>
                                    <input name="project_name" wire:model.defer="project_name"  type="text" class="form-control" required>
                                    @error('project_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                             
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="project_owner" >Project Owner</label>
                                    <input name="project_owner"  wire:model.defer="project_owner"  type="text" class="form-control" required>
                                    @error('project_owner') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                          
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="estimated_budget" class="">Estimated Budget</label>
                                    <input class="form-control currency" wire:model.defer="estimated_budget"  type="number" step='0.01' value='0.00' name="estimated_budget" placeholder='0.00' />
                                    @error('estimated_budget') <span class="text-danger">{{ $message }}</span> @enderror
                               
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="project_started" class="">Start Date</label>
                                    <input name="project_started" id="project_started" wire:model.defer="project_started"  type="date" class="form-control">
                                    @error('project_started') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="project_ended" class="">End Date</label>
                                    <input name="project_ended" id="project_ended" wire:model.defer="project_ended"  type="date" class="form-control">
                                    @error('project_ended') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            
                              
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="project_status" class="">Status</label>
                                    <select name="project_status" id="project_status" wire:model.defer="project_status"  type="text" class="form-control " title="Select Project Status"  required>
                                        <option value="" >-- Select status --</option>
                                        <option value="1">Active</option>
                                        <option value="2">Completed</option>
                                        <option value="3">Pending</option>
                                        <option value="4">Stopped</option>
                                    </select>
                                    @error('project_status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_location" class="">Location</label>
                                    <input name="project_location" id="project_location" wire:model.defer="project_location"  type="text" class="form-control" >
                                    @error('project_location') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            
                            <div class="col-md-6" >
                                <div class="form-group" >
                                    <label for="project_type" class="">Services</label>
                                    <div wire:ignore>
                                    <select name="project_type[]" style="width: 100%;" id="project_type" wire:model.defer="project_type" class="form-control" select2-hidden-accessible multiple  required >
                                        @foreach ($services as $service)
                                        <option value="{{$service->id}}">{{$service->service_name}}</option>
                                        @endforeach
                                    </select>

                                    </div>
                                    @error('project_type') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="project_description" class="">Project Description</label>
                                    <textarea wire:model.defer="project_description"  name="project_description" id="project_description"  class="form-control" > </textarea>
                                    @error('project_description') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                        </div>

                            <button wire:click.prevent="store()" class=" btn btn-info px-5 py-2  float-right">Create Project</button>
                            <button wire:click.prevent="listMode()" class=" btn btn-warning px-5 py-2 mr-3  float-right">Return to List</button>

                       
                    {{-- </form> --}}




                </div>
            </div>

        </div>
        
    </div>
    


    <script>
        $(document).ready(function () {
    // $('#project_status').selectpicker();
          
            $('#project_type').select2({
                allowClear: true,
                placeholder: 'Select a type of service'
            });
            $('#project_type').on('change', function (e) {
                let data = $(this).val();
                 @this.set('project_type', data);
            });
            window.livewire.on('productServiceStore', () => {
                $('#project_type').select2();
                $('#project_type').select2().val('').change();
            });
        });  
    </script>
</div>