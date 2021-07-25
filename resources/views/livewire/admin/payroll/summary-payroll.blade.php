<div>
    <title>Payroll Printed Summary | True Values</title>
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
                <div class="page-title-icon bg-success">
                    <i class="pe-7s-check  text-white">
                    </i>
                </div>
                <div>Approved Summary
                    <div class="page-title-subheading">You cannot edit data once it was approved, this will be served as a copy of payslips.
                    </div>
                </div>
            </div>
        </div>
    </div>    
        <div class="card no-shadow bg-transparent no-border rm-borders mb-3">
            <div class="card">
                <div class="card-header">
                    <h6>Approved Summary</h6>
                </div>
                <div class="no-gutters row">
                    <div class="col-md-12 col-lg-4">
                        <ul class="list-group list-group-flush">
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">{{$payroll_description}}</div>
                                                @php
                                                    $payrollFrom = Carbon\Carbon::parse($payroll_from_date)->format('F d, Y');
                                                    $payrollTo = Carbon\Carbon::parse($payroll_to_date)->format('F d, Y'); 
                                                @endphp
                                                <div class="widget-subheading">{{$payrollFrom . ' - ' . $payrollTo}}</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers 
                                                @if ($payroll_status == "approved")
                                                text-success  
                                                @elseif ($payroll_status == "printed")
                                                text-primary  
                                                @endif ">{{ucwords($payroll_status)}}</div>
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
                                                <div class="widget-numbers text-primary">{{$printedPayrolls->count()}}</div>
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
                                                <div class="widget-subheading">Approved By</div>
                                                <div class="widget-heading">{{$approved_by}}  <small>{{ucwords($approved_role)}}</small></div> 
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
                                                <div class="widget-heading">Salaries</div>
                                                <div class="widget-subheading">Total Salaries Amount</div>
                                            </div>
                                            <div class="widget-content-right">
                                                {{-- @php
                                                    $total_gross = $payrollSummaries->sum('total_salarypay_with_tax') + $payrollSummaries->sum('total_overtimepay_with_tax');
                                                    $cash_advance = $cash_adv->sum('cash_amount');
                                                    $grand_total = $total_gross - $cash_advance;   
                                                    if($grand_total < 0){
                                                        $grand_total = 0;
                                                    }           

                                                @endphp --}}
                                                <div class="widget-numbers text-danger">&#8369; {{number_format($printedPayrolls->sum('total_net_pay') - $printedPayrolls->sum('cash_advance'),2)}}</div>
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
                                                <div class="widget-numbers text-primary">{{$holidays}}</div>
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
                                              
                                                <div class="col-md-12 ">
                                                    <div class="dropdown  float-left">
                                                        <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-alternate">Export / Download</button>
                                                        
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                                                            <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">PDF</button>
                                                            <button type="button" tabindex="0" class="dropdown-item">Excel</button>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown  float-left">
                                                        <select name="" id="" class="form-control" style="font-size:12px !important; height:35px;">
                                                            <option value="" ><small> -- Select Work Designated -- </small></option>
                                                            <option value="">Project 1</option>
                                                            <option value="">JGM</option>
                                                        </select>
                                                       
                                                    </div>
                                                   
                                                    <div class="search-wrapper active float-right">
                                                        <div class="input-holder ">
    
                                                            <input type="text" class="search-input " wire:model="searchTerm" placeholder="Type to search">
    
                                                            <button class="search-icon"><span></span></button>
                                                        </div>
                                                    </div>
                                                    @dd($printedPayrolls)
                                                   
                                                </div>
                                            </div>
                                            <div class=" table-responsive " style="height: 325px;">
                                                
                                   <table  class="table table-striped table-bordered " id="position-table" >
                                    
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Biometric ID</th>
                                            <th width="20%">Employee</th>
                                            <th>Work Area</th>
                                            <th>Regular Shift Hours</th>
                                            <th>Total Overtime <small>Hours</small></th>
                                            <th>Total Working Hours</th>
                                            <th>Total Holiday Pay</th>
                                            <th>Gross Salary</th>
                                            <th>Total Cash Advance</th>
                                            <th>Total Pay</th>
                                            <th class="text-center" width="50px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if(!$printedPayrolls)
                                            <tr><td colspan="6" class="text-center"><h4>No payroll data found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($printedPayrolls as $printed)
                                        <tr>
                                       

                                            <td>{{$printed->employee_id}}</td>
                                            <td>{{$printed->biometric_id}}</td>
                                            <td class="text-left"><strong>{{$printed->employee_name}}</strong>
                                            <p style=" margin:-5px 0 0 0 ;"><small>{{$printed->position_title}}</small></p>
                                            </td>
                                            <td>{{$printed->project_designated}}</td>
                                       
                                             @php
                                                $perHour = $printed->salary_rate/8;
                                                $totalRegularHours = $printed->total_hours_regular;
                                                $totalOvertime = $printed->total_hours_overtime;
                                                $totalHours =  $totalRegularHours + $totalOvertime;

                                            @endphp
                                            <td>{{$totalRegularHours}}</td>
                                            <td>{{$totalOvertime}}</td>
                                            <td>{{$totalHours}}</td>
                                            <td>{{number_format($printed->total_holidaypay,2) }}</td>
                                            <td>{{number_format($printed->salary_gross,2) }}</td>
                                            <td>{{number_format($printed->cash_advance,2)}}</td>
                                            <td>{{number_format($printed->total_net_pay,2)}}</td>
                                            <td class="text-center"><div class="dropdown">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                        <button wire:click="printSinglePayslip({{$printed->id}})" tabindex="0" class="dropdown-item">Print Payslip</button>
                                                        <button wire:click="printSinglePayslip({{$printed->id}})" tabindex="0" class="dropdown-item">View Attendance</button>
                                                </div>
                                            </div></td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                                  <div class="card-footer justify-content-center">
                                    {{$printedPayrolls->links('pagination')}}
    
                                  </div>
                                </div>
    
                            </div>
                            
                        </div>
        
                    </div>
        
                </div>
                
                <div class="float-right mt-3">
                    <a href="{{route('admin.list-payrolls')}}" class=" btn btn-warning px-5 py-2 ">Go Back</a>
                    @if ($approved_by)
                    <button wire:click.prevent="bulkPayslipPDF()" class=" btn btn-primary px-5 py-2 ml-2 ">Print Payslip</button>
                    @endif
                 
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
    
    