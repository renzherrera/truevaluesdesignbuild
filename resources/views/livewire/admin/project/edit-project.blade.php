<div>

   
    
        
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-2 card">
                <div class="card-body m-3"><h5 class="card-title ">Edit Project Details</h5>
                    {{-- <form action="{{route('admin.positions.store')}}" method="POST"> --}}
                        {{-- @csrf --}}
                        {{-- <div class="form-row">
                            <input type="file" name="" id="">
                        </div> --}}
                        <input name="selected_id" wire:model="selected_id"  type="text" class="form-control" hidden readonly>

                        <div class="form-row container-fluid pb-4">
                           
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

                            <div class="col-md-3" >
                                <div class="form-group" >
                                    <label for="project_type" class="">Services</label>
                                    <div wire:ignore>
                                    <select name="project_type[]" style="width: 100%;" id="project_type" class="form-control" select2-hidden-accessible multiple   required >
                                        @foreach ($services as $service)
                                        <option value="{{$service->id}}"

                                            {{-- the project type is encoded already, we don't have to initiate a encode value. --}}

                                            @foreach ($selected->services as $selectedProject)

                                                
                                            @if ($service->id == $selectedProject->id)
                                                selected
                                            @endif
                                            
                                            @endforeach
                                            
                                            >{{$service->service_name}}</option>
                                        @endforeach
                                    </select>

                                    </div>
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
                                        <option value="2">Completed</option>
                                        <option value="3">Pending</option>
                                        <option value="4">Stopped</option>
                                    </select>
                                    @error('project_status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="project_description" class="">Project Description</label>
                                    <textarea wire:model="project_description"  name="project_description" id="project_description"  class="form-control" > </textarea>
                                    @error('project_description') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div> 
                        </div>

                            <button wire:click.prevent="update()" class=" btn btn-primary px-5 py-2  float-right">Save Changes</button>
                            <button wire:click.prevent="listMode()" class=" btn btn-warning px-5 py-2 mr-3  float-right">Cancel</button>

                       
                    {{-- </form> --}}




                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            window.addEventListener('reApplySelect2', event => {
                let data = $(this).val();
                 @this.set('project_type', data);
        });
            $('#project_type').select2({
                allowClear: true,
                placeholder: 'Select a type of service'
            });
            $('#project_type').on('select2:select', function (e) {
                let data = $(this).val();
                 @this.set('project_type', data);
            });
           
            window.livewire.on('productServiceStore', () => {
                $('#project_type').select2();
                // $('#project_type').select2().val('').change();
            });
            window.livewire.on('bindModel', () => {
                let data = $(this).val();
                 @this.set('project_type', data);
            });
        });  
    </script>


</div>