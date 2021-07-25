<div>
    <title>List of Schedules | True Values</title>
    <style>
        nav svg{
            height: 20px;
        }
        .search-wrapper {
            margin: 0 !important;
            padding-bottom: 5px;
        
        }
        .input-holder{
            margin: 0 !important;
            float: right !important;
        }
      </style>
    </head>
    
       
            
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon bg-info">
                            <i class="pe-7s-date text-white">
                            </i>
                        </div>
                        <div>Schedules
                            <div class="page-title-subheading">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde labore eaque blanditiis officia quia nulla..
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
            @if ($updateMode)
                
            @include('livewire.admin.schedule.edit-schedule')
            @else
            @include('livewire.admin.schedule.create-schedule')
    
            @endif
            
                
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    
                    <div class="main-card card ">
                        <div class="card-body">
    
                                        {{-- {{ $dataTable->table() }} --}}
                                <div class="col-sm-12  date-filter" style="width: 100%">
                                            
                                            <div class="form-row ">
                                                <div class="col-md-4 ">
                                                <h4 class="card-title">List of Schedules</h4>
                                                
    
                                                    {{-- <div class="form-row input-daterange">
                                                        <div class="form-group col-md-5 ">
                                                            <input style="cursor: pointer; font-size: 13px;" type="text" id="from_date" name="from_date" class="form-control datepicker" placeholder="From Date" readonly>
                                                        </div>
                                                        <div class="form-group col-md-5">
                                                            <input style="cursor: pointer; font-size: 13px;" type="text" id="to_date"  name="to_date" class="form-control datepicker" placeholder="To Date" readonly>
            
                                                        </div>
                                                      
                                                        <div class="form-group col-md-2 " id="">
                                                        <button type="button" class="btn btn-info form-control" id="filter" name="filter">Filter</button>
                                                        </div>
                                                        
                                                        
                                                    </div> --}}
                                                </div>
                                                
                                            </div>
                                            <div class=" table-responsive " style="height: 315px;">
                                                
                                   <table  class="table table-striped table-bordered" id="position-table" >
                                    
                                    <thead>
                                        <tr>
                                            <th width="200px">Schedule Title</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if($schedules->count() < 1)
                                            <tr><td colspan="4" class="text-center"><h4>No schedule found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($schedules as $schedule)
                                        <tr>
                                           
                                            <td>{{$schedule->schedule_title}}</td>
                                            <td>{{$schedule->start_time}}</td>
                                            <td>{{$schedule->end_time}}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                        <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                            <button wire:click="edit({{$schedule->id}})" tabindex="0" class="dropdown-item">Edit</button>
                                                        
                                                        <button wire:click.prevent="$emit('deleteSchedule',{{$schedule}})" class="dropdown-item" type="button"> Delete</button>
                                                    </div> 
                                              </div>
                                            </td>
                                        </tr> 
                                         @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                                  <div class="card-footer justify-content-center">
                                     {{$schedules->links('pagination')}}
    
                                  </div>
                                </div>
    
                                
                               
                            </div>
    
                            
                        </div>
        
                    </div>
        
                </div>
                
        </div>
            
        <script>
            document.addEventListener('livewire:load', function () {
                @this.on('deleteSchedule', id => {
                    Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                        //if user clicks on delete
                        if (result.value) {
                            // calling destroy method to delete
                            @this.call('destroy',id)
                            Swal.fire(
                                'Deleted!',
                                'Schedule has been deleted.',
                                'success'
                            )
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Deleting schedule cancelled :)',
                                'error'
                            )
                        }
                    });
                })
            })
        </script>
        
    </div>
    
    
    