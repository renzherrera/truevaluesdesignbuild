<div>
    <title>List of Attendance | True Values</title>
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
    
       
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-paper-plane text-success">
                            </i>
                        </div>
                        <div>Attendance
                            <div class="page-title-subheading">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde labore eaque blanditiis officia quia nulla..
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        
            @if ($updateMode)
                
            @include('livewire.admin.attendance.edit-attendance')
            @else
            @include('livewire.admin.attendance.create-attendance')
            @endif
            

                
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="main-card card ">
                        <div class="card-body">
                                <div class="col-sm-12  date-filter" style="width: 100%">
                                            
                                            <div class="form-row ">
                                                <div class="col-md-4 ">
                                                <h4 class="card-title">List of Attendances</h4>
                                                
                                                </div>
                                                <div class="col-md-12 float-right">
                                                    <div class="dropdown  float-left">
                                                        <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-alternate">Import / Export</button>
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                                                            <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">Download PDF</button>
                                                            <button type="button" tabindex="0" class="dropdown-item">Download Excel</button>
                                                            <button type="button" tabindex="0" class="dropdown-item"data-toggle="modal" data-target="#exampleModal">Import Excel/CSV</button>
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="search-wrapper active float-right">
                                                        <div class="input-holder ">
    
                                                            <input type="text" class="search-input " wire:model="searchTerm" placeholder="Type to search">
    
                                                            <button class="search-icon"><span></span></button>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                <div class=" table-responsive " style="height: 325px;">
                                                
                                   <table  class="table table-striped table-bordered" id="position-table" >
                                    
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th width="200px">Biometric ID</th>
                                            <th>Date of Attendance</th>
                                            <th>Time-in</th>
                                            <th>Time-out</th>
                                            <th>Total hours</th>
                                            <th>Time-in <small>[Overtime]</small></th>
                                            <th>Time-out <small>[Overtime]</small></th>
                                            <th>Ot hours</th>
                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if($attendances->count() < 1)
                                            <tr><td colspan="100%" class="text-center"><h4>No attendance data found.</h4></td></tr>
                                        
                                        @endif
                                            
                                        @foreach ($attendances as $attendance)

                                        <tr>
                                            <td>{{$attendance->employees->first_name . ' ' . $attendance->employees->middle_name .' ' . $attendance->employees->last_name}}</td>
                                            <td>{{$attendance->biometric_id}}</td>
                                            <td>{{ Carbon\Carbon::parse($attendance->attendance_date)->format('F d, Y') }}</td>
                                            <td>{{ Carbon\Carbon::parse($attendance->first_onDuty)->format('g:i A') }}</td>
                                            <td class="text-center">
                                                @if ($attendance->first_offDuty)
                                                {{ Carbon\Carbon::parse($attendance->first_offDuty)->format('g:i A') }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            @php
                                            $timeIn = \Carbon\Carbon::parse($attendance->first_onDuty);
                                            $timeOut = \Carbon\Carbon::parse($attendance->first_offDuty);
                                            $diffInHours = round($timeOut->diffInMinutes($timeIn) / 60); 
                                            if($diffInHours >4){
                                            $diffInHours = round($timeOut->diffInMinutes($timeIn) / 60) - 1; 

                                            }
                                            if (!$attendance->first_offDuty) {
                                                $diffInHours= 4;
                                            }

                                            $ottimeIn = \Carbon\Carbon::parse($attendance->second_onDuty);
                                            $ottimeOut = \Carbon\Carbon::parse($attendance->second_offDuty);
                                            $otdiffInHours = round($ottimeOut->diffInMinutes($ottimeIn) / 60) ; 
                                            if($otdiffInHours >4){
                                            $otdiffInHours = round($ottimeOut->diffInMinutes($ottimeIn) / 60) - 1; 

                                            }
                                            if (!$attendance->second_offDuty) {
                                                $otdiffInHours= 0;
                                            }
                                           @endphp
                                        <td>{{$diffInHours}}</td>
                                            <td>
                                                @if ($attendance->second_onDuty)
                                                {{ Carbon\Carbon::parse($attendance->second_onDuty)->format('g:i A') }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                          
                                            <td>
                                                @if ($attendance->second_offDuty)
                                                {{ Carbon\Carbon::parse($attendance->second_offDuty)->format('g:i A') }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                             <td>{{$otdiffInHours}}</td>

                                            <td class="text-center"><div class="dropdown">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                        <button wire:click="edit({{$attendance->id}})" tabindex="0" class="dropdown-item">Edit</button>
                                                    <button wire:click.prevent="$emit('deleteAttendance',{{$attendance->id}})" class="dropdown-item" type="button"> Delete</button>
                                                </div>
                                            </div></td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                  </table>
                                  </div>
                                  <div class="card-footer justify-content-center">
                                    {{$attendances->links('pagination')}}
    
                                  </div>
                                </div>
    
                                
                               
                            </div>
    
                            
                        </div>
        
                    </div>
        
                </div>
                
            </div>

            <style>
                .modal-backdrop {
                    /* bug fix - no overlay */    
                    display: none;    
                }
                .modal {
                    top:20%;
        
                }
            </style>
            <div class="modal fade bd-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning mt-2 mb-2 fade show" role="alert">
                                <h4 class="alert-heading">Reminder!</h4>
                                <p class="mb-0 ">Before you import, be sure to change the date format on your excel sheet #4 (Exception Statistic Report). <br> <br> 
                                    Click <a href="{{asset('assets/howToChangeDateFormat.pdf')}}" download>here</a> to download tutorial pdf <small>(How to change date format)</small> .</p>
                                <br>
                                
                            </div>
                            <hr>
                           
                            <div class="form-group">
                                <label for="importExcelFile">Import Excel / CSV File</label><br>
                                <label for="importExcelFile" class="btn btn-outline-alternate">Browse Files</label><br>
                                <p> {{$importExcelFile}}</p>
                                <input hidden type="file" name="importExcelFile" id="importExcelFile" wire:model.defer="importExcelFile" accept=".xlsx, .xls, .csv" required> <br>
                                @error('importExcelFile') <span class="text-danger">You have to browse/choose a valid file.</span> @enderror
                                
                            </div>
                  
        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <div wire:loading.remove>
                            <button type="button" class="btn btn-alternate" wire:click="import()" >Import to Database</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <script>
            document.addEventListener('livewire:load', function () {
                @this.on('deleteAttendance', id => {
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
                           
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Deleting data cancelled :)',
                                'error'
                            )
                        }
                    });
                })
            })
        </script>
        
        
        
</div>
   
    