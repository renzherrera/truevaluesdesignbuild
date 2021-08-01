<div>
    <title>List of Payrolls | True Values</title>
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
        .modal-backdrop {
            /* bug fix - no overlay */    
            display: none;    
        }
        .modal {
            top:20%;
        }
      </style>
    </head>
    
    

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon bg-warning">
                    <i class="pe-7s-clock text-white">
                    </i>
                </div>
                <div>Preview Summary
                    <div class="page-title-subheading">In preview summary, you can still edit necessary data (e.g. Attendances, Salary etc.) while there is no approval yet.
                    </div>
                </div>
            </div>
        </div>
    </div>    
        <div class="card no-shadow bg-transparent no-border rm-borders mb-3">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title float-left">
                    @if ($payrolls->projects)
                    {{$payrolls->projects->project_name}}  
                    @else
                    All 
                     @endif Payroll</h4> 
{{$this->employee_preview_biometric_id}}

                </div>
                <div class="no-gutters row">
                    <div class="col-md-12 col-lg-4">
                        <ul class="list-group list-group-flush">
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            @if ($payrollSummaries)
                                                
                                            <div class="widget-content-left">
                                                <div class="widget-heading">{{$payroll_description}}</div>
                                                @php
                                                    $payrollFrom = Carbon\Carbon::parse($payroll_from_date)->format('F d, Y');
                                                    $payrollTo = Carbon\Carbon::parse($payroll_to_date)->format('F d, Y'); 
                                                @endphp
                                                <div class="widget-subheading">{{$payrollFrom . ' - ' . $payrollTo}}</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-warning">{{ucwords($payroll_status)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-subheading">Created By</div>
                                                <div class="widget-heading">{{$prepared_by}} <small>{{ucwords($prepared_role)}}</small></div> 

                                            </div>
                                            
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-primary"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <ul class="list-group list-group-flush">
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Employees</div>
                                                <div class="widget-subheading">Total Listed Employees</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-primary">{{$payrollSummaries->count()}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Holidays</div>
                                                <div class="widget-subheading">Total Holiday Counts</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-info">{{$holidays}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">NO TIME OUT RECORD</div>
                                                <div class="widget-subheading">Total Listed Employees</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-primary">{{$payrollSummaries->count()}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <ul class="list-group list-group-flush">
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Salaries</div>
                                                <div class="widget-subheading">Total Salaries Amount</div>
                                            </div>
                                            <div class="widget-content-right">
                                                @php
                                                    $total_gross_holiday_minus_cashadvance = $payrollSummaries->sum(function ($item) {
                                                            return $item->total_minus_cashadvances >   0 ? $item->total_minus_cashadvances : 0;
                                                        });
                                                                                   
                                                @endphp
                                                <div class="widget-numbers text-danger">&#8369; {{number_format($total_gross_holiday_minus_cashadvance,2)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    
                    <div class="main-card card ">
                        <div class="card-body">
    
                                        {{-- {{ $dataTable->table() }} --}}
                                <div class="col-sm-12  date-filter" style="width: 100%">
                                            
                                            <div class="form-row ">
                                                <div class="col-md-4 ">
                                                
                                                </div>
                                                <div class="col-md-12 float-right">
                                                    <div class="dropdown  float-left">
                                                        <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-alternate">Export / Download</button>
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                                                            <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">PDF</button>
                                                            <button type="button" tabindex="0" class="dropdown-item">Excel</button>
                                                          
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
                                                
                                   <table  class="table table-striped table-bordered " id="position-table" >
                                    
                                    <thead>
                                        <tr>
                                            <th width="200px">Id</th>
                                            <th>Employee</th>
                                            <th>Regular Shift Hours</th>
                                            <th>Total Overtime <small>Hours</small></th>
                                            <th>Total Working Hours</th>
                                            <th>Total Holiday Pay</th>
                                            <th>Gross Salary</th>
                                            <th>Total Cash Advance</th>
                                            <th>Total Pay</th>
                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    @endif 
                                    {{-- end of checking payrollsummaries count --}}

                                    <tbody>
                                        @if(!$payrollSummaries)
                                            <tr><td colspan="6" class="text-center"><h4>No payroll data found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($payrollSummaries as $payrollSummary)
                                        @php
                                                $perHour = $payrollSummary->salary_rate/8;
                                                $totalRegularHours = $payrollSummary->total_regular_hours;
                                                $totalOvertime = $payrollSummary->total_overtime_hours;
                                                $totalHours =  $totalRegularHours + $totalOvertime;
                                                $payGross = $payrollSummary->total_salarypay_with_tax + $payrollSummary->total_overtimepay_with_tax;
                                                $cashAdvance = $payrollSummary->cashadvances
                                                                              ->whereBetween('requested_date',[$this->payroll_from_date,$this->payroll_to_date])
                                                                              ->where('status','==','approved')
                                                                              ->sum('cash_amount');
                                                $totalPay = $payGross - $cashAdvance;
                                                $this->total_pay = $totalPay;
                                            @endphp
                                        <tr class="{{$totalPay < 0 ? 'text-danger bg-light ' : ''}}" >

                                            <td>{{$payrollSummary->id}}</td>
                                            <td>{{$payrollSummary->first_name . ' ' . $payrollSummary->middle_name . ' ' . $payrollSummary->last_name}}</td>
                                          
                                             
                                            <td>{{$totalRegularHours}}</td>
                                            <td>{{$totalOvertime}}</td>
                                            <td>{{$totalHours}}</td>
                                            <td>{{$payrollSummary->regularholiday_pay + $payrollSummary->overtimeholiday_pay}}</td>
                                            <td>{{number_format($payGross,2) }}</td>
                                            <td>{{number_format($cashAdvance,2)}}</td>
                                            <td>{{number_format($totalPay,2)}}</td>
                                            <td class="text-center"><div class="dropdown">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                    <button wire:click.prevent="viewAttendance({{$payrollSummary->biometric_id}})" class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-lg">View Attendance</button>
                                                    <button wire:click="edit({{$payrollSummary->id}})" tabindex="0" class="dropdown-item">Edit</button>
                                                    
                                                    <button wire:click.prevent="$emit('deletePosition',{{$payrollSummary}})" class="dropdown-item" type="button"> Delete</button>
                                                </div>
                                            </div></td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                                  <div class="card-footer justify-content-center">
                                    {{$payrollSummaries->links('pagination')}}
    
                                  </div>
                                </div>
    
                            </div>
                            
                        </div>
        
                    </div>
        
                </div>




 


                
                <div class="float-right mt-3">
                    <a href="{{route('admin.list-payrolls')}}" class=" btn btn-warning px-5 py-2 ">Go Back</a>
                    @if ($approved_by)
                    <button wire:click.prevent="$emit('generate')" class=" btn btn-primary px-5 py-2 ml-2 ">Generate Payslip</button>
                        
                    @endif
                    {{-- @if ($payroll_status == "pending" && Auth::user()->role == "superadmin")
                    <button wire:click.prevent="approved({{$selected_payroll}})" class=" btn btn-success px-5 py-2 ml-2 ">Approve</button>
                    @endif --}}
                </div>
            </div>
            {{-- @endif --}}
            
            
        <script>
            document.addEventListener('livewire:load', function () {
                @this.on('deletePosition', id => {
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
                            location.reload();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Deleting data cancelled :)',
                                'error'
                            )
                        }
                    });
                })

                @this.on('generate', id => {
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
                            @this.call('bulkPayslipPDF')
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


<!-- Large modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Attendance Summary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class=" table-responsive " style="height: 325px;">
                                                
                    <table  class="table table-striped table-bordered" id="position-table" >
                     
                     <thead>
                         <tr>
                             <th>Date</th>
                             <th>Time-in</th>
                             <th>Time-out</th>
                             <th>Total hours</th>
                             <th>Time-in <small>[Overtime]</small></th>
                             <th>Time-out <small>[Overtime]</small></th>
                             <th>Ot hours</th>
                             <th class="text-center" width="50px">Action</th>
                         </tr>

                     </thead>
                     <tbody>
                         @if($attendances->count() < 1)
                             <tr><td colspan="100%" class="text-center"><h4>No attendance data found.</h4></td></tr>
                         
                         @endif
                             
                         @foreach ($attendances as $attendance)

                         <tr>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>



   
    </div>
    
    