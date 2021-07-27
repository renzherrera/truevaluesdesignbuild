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
        div.disabled
        {
        pointer-events: none;

        /* for "disabled" effect */
        opacity: 0.5;
        background: #CCC;
        }
      </style>
    </head>
    
       
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon bg-alternate">
                            <i class="pe-7s-clock text-white">
                            </i>
                        </div>
                        <div>Attendance
                            <div class="page-title-subheading">Please make sure Employees are registered in the designated Biometric ID.
                            </div>
                        </div>
                    </div>
                </div>
            </div>           

            <div>
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card mb-3 widget-content bg-night-fade">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Total Lates </div>
                                    <div class="widget-subheading">Late attendance records</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white"><span>{{$lateCounts}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card mb-3 widget-content bg-arielle-smile">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">No Time-out Records</div>
                                    <div class="widget-subheading">Employees who has no time-out records</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white"><span>{{$noTimeOutRecords}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card mb-3 widget-content bg-happy-green">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Early Out</div>
                                    <div class="widget-subheading">Incompete working hours w/ Early Out</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white"><span>{{$earlyOutCounts}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" d-lg-block col-md-6 col-xl-3">
                        <div class="card mb-3 widget-content bg-premium-dark">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Unenrolled Id</div>
                                    <div class="widget-subheading">no. of Attendances[Unenrolled]: <strong>{{$unenrolledAttendance}}</strong></div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-warning"><span>{{$unenrolledId}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- @if ($updateMode)
                
            @include('livewire.admin.attendance.edit-attendance')
            @else
            @include('livewire.admin.attendance.create-attendance')
            @endif --}}
            
            {{-- @livewire('admin.attendance.widget-attendance', ['searchTerm' => $searchTerm]) --}}
                
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <h5>List of Attendances    </h5>
                    
                    <div class="dropdown ">
                        <div class="btn btn-dark float-left d-flex mr-3" style="cursor: pointer;" data-toggle="modal" data-target="#attendance_modal"> 
                            <i class="pe-7s-plus text-white pr-3"  style="font-size: 19px!important; ">
                            </i>
                            <span style="vertical-align: baseline; margin:auto; font-size:13px; padding-right:25px;">Add Record</span>
                        </div>
                        <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2  dropdown-toggle btn btn-outline-alternate">Import / Export</button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                            <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">Export PDF</button>
                            {{-- <button type="button" tabindex="0" class="dropdown-item">Download Excel</button> --}}
                            <button type="button" tabindex="0" class="dropdown-item"data-toggle="modal" data-target="#importModal">Import Excel/CSV</button>
                          
                        </div>
                    </div>
                    <div class="main-card card ">
                        
                        <div class="card-body">
                                <div class="col-sm-12  date-filter" style="width: 100%">
                                            <div class="form-row mb-3">
                                                    {{-- {{Carbon\Carbon::parse($start)->format('F d, Y') . ' - ' . Carbon\Carbon::parse($end)->format('F d, Y')}} --}}
                                                     
                                                        <div class="col-md-12" style="padding:0 !important; margin:0!important;">
                                                            
                                                        <div class="col-md-3 float-left" style="padding: 0 !important;" wire:ignore>
                                                            <label class="text-muted"><input type="checkbox" name="checkDatepicker" id="checkDatepicker" class="float-left" style="z-index: 999999; height: 20px; " value="value">&nbsp; <small>Filter by: Date</small></label>
                                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center;margin-top: -5px;" class="disabled">
                                                                <i class="fa fa-calendar "></i>&nbsp;
                                                                <span></span> <i class="fa fa-caret-down float-right"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 float-left " >
                                                            <label class="text-muted"><small>Filter by: Department / Project</small></label>

                                                            
                                                            {{-- <label for=""><small>Filter</small></label> --}}
                                                          <select wire:model= "project_id" class="form-control text-center " style="height: 33px; font-size: 14px; margin-top: -5px;cursor:pointer;">
                                                              <option value="" >All</option>
                                                              @foreach ($projects as $project)
                                                              <option value="{{$project->id}}" >{{$project->project_name}}</option>
                                                              @endforeach
                                                          </select>
                                                        </div>
                                                        
    
                                                        <div class="search-wrapper  active float-right">
                                                            <div class="input-holder ">
                                                                <input type="text" class="search-input " wire:model="searchTerm" placeholder="Type to search">
                                                                <button class="search-icon"><span></span></button>
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                 
                                             {{-- date range picker data source  --}}
                                                <input type="text" id="start" wire:model ="start" hidden>
                                                <input type="text" id="end" wire:model ="end" hidden>
                                                   
                                                </div>
                                <div class=" table-responsive " style="height: 325px;">
                                                
                                   <table  class="table table-striped table-bordered" id="position-table" >
                                    
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th width="150px">Biometric ID</th>
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
                                            {{-- @dd($attendance->employees->schedule->start_time) --}}
                                            <td><span class="text-muted text-xs">#&nbsp;</span>{{$attendance->employees->id}}</td>
                                            <td>{{$attendance->employees->first_name . ' ' . $attendance->employees->middle_name .' ' . $attendance->employees->last_name}}</td>
                                            <td><span class="text-muted text-xs">#&nbsp;</span>{{$attendance->biometric_id}}</td>
                                            <td>{{ Carbon\Carbon::parse($attendance->attendance_date)->format('F d, Y') }}</td>
                                            <td>{{ Carbon\Carbon::parse($attendance->first_onDuty)->format('g:i A') }}</td>
                                            <td class="text-center">
                                                @if ($attendance->first_offDuty)
                                                {{ Carbon\Carbon::parse($attendance->first_offDuty)->format('g:i A') }}
                                                @elseif($attendance->second_onDuty && !$attendance->second_offDuty)
                                                {{ Carbon\Carbon::parse($attendance->second_onDuty)->format('g:i A') }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            @php
                                            $timeIn = \Carbon\Carbon::parse($attendance->first_onDuty);
                                            $timeOut = \Carbon\Carbon::parse($attendance->first_offDuty);
                                            $ottimeIn = \Carbon\Carbon::parse($attendance->second_onDuty);
                                            $ottimeOut = \Carbon\Carbon::parse($attendance->second_offDuty);
                                            $otdiffInHours = round($ottimeOut->diffInMinutes($ottimeIn) / 60) ; 
                                           
                                            if ($attendance->first_offDuty){
                                            $diffInHours = round($timeOut->diffInMinutes($timeIn) / 60);
                                                if($diffInHours >4){
                                                $diffInHours = round($timeOut->diffInMinutes($timeIn) / 60) - 1; 
                                                    }
                                            }
                                            elseif($attendance->second_onDuty && !$attendance->first_offDuty){
                                            $diffInHours = round($ottimeIn->diffInMinutes($timeIn) / 60);
                                            if($diffInHours > 8){
                                                $diffInHours =8;
                                            }
                                            }
                                            else {
                                            $diffInHours= 4;
                                            }

                                            // if($diffInHours >4){
                                            // $diffInHours = round($timeOut->diffInMinutes($timeIn) / 60) - 1; 
                                            // }
                                           
                                            if($otdiffInHours >4){
                                            $otdiffInHours = round($ottimeOut->diffInMinutes($ottimeIn) / 60) - 1; 
                                            }
                                            
                                            if (!$attendance->second_offDuty){ 
                                                $otdiffInHours= 0;
                                            }
                                           
                                           @endphp
                                        <td style="font-weight: 700" class="text-center {{$diffInHours >= 8 ? 'text-primary' : ($diffInHours < 8 && $diffInHours > 4 ? 'text-warning' : 'text-danger')}}">{{$diffInHours}}</td>
                                            <td>
                                                @if ($attendance->second_onDuty && $attendance->second_offDuty)
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
                                            <td style="font-weight: 700" class="text-center {{$otdiffInHours >= 8 ? 'text-primary' : ($otdiffInHours < 8 && $otdiffInHours > 4 ? 'text-warning' : ($otdiffInHours == 0 ? 'text-dark' : 'text-danger'))}}">
                                              
                                                @if ($otdiffInHours == 0)
                                                -
                                                @else
                                                {{$otdiffInHours}}
                                                @endif
                                            </td>

                                            <td class="text-center"><div class="dropdown">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class=" btn btn-outline-link hover"> <i class="metismenu-icon pe-7s-config"></i></button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                        <button wire:click.prevent="edit({{$attendance->attendance_id}})" data-toggle="modal" data-target='#attendance_modal' type="button" class="dropdown-item">Edit</button>
                                                    <button wire:click.prevent="$emit('deleteAttendances',{{$attendance->attendance_id}})" class="dropdown-item" type="button"> Delete</button>
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
            @include('livewire.admin.attendance.create-modal')
            @include('livewire.admin.attendance.import-modal')
            <script>
               window.livewire.on('toggleAttendanceModal', () => $('#attendance_modal').modal('toggle'));
                </script>
        <script type="text/javascript">

            $(function() {
             
                var start = moment();
                var end = moment();
                var checkBox = document.getElementById("checkDatepicker");
                checkBox.checked = false;
                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    var element = document.getElementById('start');
                    var element1 = document.getElementById('end');
                    if (checkBox.checked == true){
                        $('#start').val(start);
                    $('#end').val(end);

               
                    element.dispatchEvent(new Event('input'));
                    element1.dispatchEvent(new Event('input'));
                    } else{
                        $('#start').val('');
                    $('#end').val('');
                
                    element.dispatchEvent(new Event('input'));
                    element.dispatchEvent(new Event('input'));
                    }
                }
            
                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                       'Today': [moment(), moment()],
                       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                       'This Month': [moment().startOf('month'), moment().endOf('month')],
                       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);
            
                cb(start, end);
                $('#checkDatepicker').change(function() {
                    if(this.checked) {
                        $('#start').val(start);
                    $('#end').val(end);

                    var element = document.getElementById('start');
                    var element1 = document.getElementById('end');
                    element.dispatchEvent(new Event('input'));
                    element1.dispatchEvent(new Event('input'));
                    $( "#reportrange" ).removeClass( "disabled" );
                cb(start, end);

                }else{
                    $('#start').val('');
                        $('#end').val('');
                    var element2 = document.getElementById('start');
                    var element3 = document.getElementById('end');
                    element2.dispatchEvent(new Event('input'));
                    element3.dispatchEvent(new Event('input'));
                    $( "#reportrange" ).addClass( "disabled" );

                cb(start, end);

                }

            });
         
            });
            </script>    
        <script>
            document.addEventListener('livewire:load', function () {
                @this.on('deleteAttendances', id => {
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
   
    