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
      </style>
    </head>
    
        <div class="card no-shadow bg-transparent no-border rm-borders mb-3">
            <div class="card">
           
                
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
                                                <div class="widget-numbers text-success">{{ucwords($payroll_status)}}</div>
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
                                                @php
                                                    $total_gross = $payrollSummaries->sum('total_salarypay_with_tax') + $payrollSummaries->sum('total_overtimepay_with_tax');
                                                    $cash_advance = $cash_adv->sum('cash_amount');
                                                    $grand_total = $total_gross - $cash_advance;   
                                                    if($grand_total < 0){
                                                        $grand_total = 0;
                                                    }                                     
                                                @endphp
                                                <div class="widget-numbers text-danger">&#8369; {{number_format($grand_total,2)}}</div>
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
                                            <th>Gross Salary</th>
                                            <th>Total Cash Advance</th>
                                            <th>Total Pay</th>
                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if(!$payrollSummaries)
                                            <tr><td colspan="6" class="text-center"><h4>No payroll data found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($payrollSummaries as $payrollSummary)
                                        <tr>
                                       

                                            <td>{{$payrollSummary->id}}</td>
                                            <td>{{$payrollSummary->first_name . ' ' . $payrollSummary->middle_name . ' ' . $payrollSummary->last_name}}</td>
                                          
                                             @php
                                                $perHour = $payrollSummary->salary_rate/8;
                                                $totalRegularHours = $payrollSummary->total_regular_hours;
                                                $totalOvertime = $payrollSummary->total_overtime_hours;
                                                $totalHours =  $totalRegularHours + $totalOvertime;
                                                $payGross = $payrollSummary->total_salarypay_with_tax + $payrollSummary->total_overtimepay_with_tax;
                                                $cashAdvance = $payrollSummary->cashadvances
                                                                              ->where('status','!=','paid')
                                                                              ->where('status','!=','pending')
                                                                              ->where('status','==','approved')
                                                                              ->sum('cash_amount');
                                                $totalPay = $payGross - $cashAdvance;
                                                $this->total_pay = $totalPay;
                                            @endphp
                                            <td>{{$totalRegularHours}}</td>
                                            <td>{{$totalOvertime}}</td>
                                            <td>{{$totalHours}}</td>
                                            <td>{{number_format($payGross,2) }}</td>
                                            <td>{{number_format($cashAdvance,2)}}</td>
                                            <td>{{number_format($totalPay,2)}}</td>



                                            <td class="text-center"><div class="dropdown">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
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
                    <button wire:click.prevent="listMode()" class=" btn btn-warning px-5 py-2 ">Go Back</button>
                    @if ($approved_by)
                    <button wire:click.prevent="bulkPayslipPDF()" class=" btn btn-primary px-5 py-2 ml-2 ">Generate Payslip</button>
                        
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
    
    