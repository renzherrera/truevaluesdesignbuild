    

            <style>
                .modal-backdrop {
                    /* bug fix - no overlay */    
                    display: none;    
                }
                .modal {
                    top:20%;
        
                }
            </style>
            <div class="modal fade bd-example-modal-lg" id="payroll_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{!$updateMode ? 'New Payroll Record' : 'Edit Record'}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="modal-body">
                                
                                <div class="form-row">
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payroll_from_date" class="">From<small>(Start Date)</small></label>
                                            <input  wire:model.defer="payroll_from_date"  type="date" class="form-control" required>
                                            @error('payroll_from_date') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12" >
                                        <div class="form-group" wire:ignore>
                                            <label for="payroll_to_date" class="mb-3">Payroll Date<small> (Date Between)</small></label>
                                            {{-- <input id  wire:model.defer="payroll_to_date"  type="date" class="form-control" required> --}}
                                           
                                            @error('payroll_to_date') <span class="text-danger">{{ $message }}</span> @enderror
                                            <div id="payroll_range" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center;margin-top: -5px;" >
                                                <i class="fa fa-calendar float-left"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down float-right"></i>
                                            </div>
                                            <input type="text" wire:model ="date_start_range" id="date_start_range" >
                                            <input type="text" wire:model ="date_end_range" id="date_end_range" >
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="payroll_description" class="">Payroll Description</label>
                                            <textarea wire:model.defer="payroll_description"  name="job_description" id="payroll_description"  class="form-control" > </textarea>
                                            @error('payroll_description') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="">Project / Department</label>
                                        <select name="" id="" wire:model.defer = "project_id" class="form-control" style="font-size: 14px;">
                                            <option value="0"> All </option>
                                            @foreach ($projects as $project)
                                            <option value="{{$project->id}}">{{$project->project_name}}</option>
                                                
                                            @endforeach
                                        </select>
                                        @error('project_id') <span class="text-danger">{{ $message }}</span> @enderror
        
                                        </div>
                                    </div>
                                    
                                </div>
                                
            
                            </div>
                        <div class="modal-footer">
                            <div wire:loading.remove>
                                @if($updateMode)
                                    <button wire:click.prevent="update()" class=" btn btn-primary px-5 py-2  float-right">Save Changes</button>
                                @else
                                <button wire:click.prevent="store()" class=" btn btn-info px-5 py-2  float-right">New Payroll</button>
                                @endif
                                <button wire:click.prevent="createMode()"  data-dismiss="modal" class=" btn btn-warning px-5 py-2 mr-3 float-right">Cancel</button>
                            </div>
                        </div>
                    </div>
            </div>
            <script type="text/javascript">

                $(function() {
                    var date_start_range = moment();
                    var date_end_range = moment();
                    function cb(date_start_range, date_end_range) {
                        $('#payroll_range span').html(date_start_range.format('MMMM D, YYYY') + ' - ' + date_end_range.format('MMMM D, YYYY'));
                        $('#date_start_range').val(date_start_range);
                        $('#date_end_range').val(date_end_range);
                        var element3 = document.getElementById('date_start_range');
                        var element4 = document.getElementById('date_end_range');
                   
               
                        element3.dispatchEvent(new Event('input'));
                        element4.dispatchEvent(new Event('input'));
                        } 
                
                    $('#payroll_range').daterangepicker({
                        startDate: date_start_range,
                        endDate: date_end_range,
                        ranges: {
                           'Today': [moment(), moment()],
                           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                           'This Month': [moment().startOf('month'), moment().endOf('month')],
                           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        }
                    }, cb);
                
                    cb(date_start_range, date_end_range);
                  
    
             
                });
                
                </script>
                
        </div>