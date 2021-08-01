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
                        <div class="page-title-icon">
                            <i class="pe-7s-cash text-primary">
                            </i>
                        </div>
                        <div>Payrolls
                            <div class="page-title-subheading">The total amount of wages and salaries paid by the company to its employees.
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        

             
                @include('livewire.admin.payroll.payroll-records-modal')

            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                  
                    <div class="form-row mb-3">
                        
                        {{-- <h4 class="card-title float-left">List of Payrolls    </h4> --}}
                            
                        <div class="col-md-12">

                            <div class="col-md-3 float-left" style="padding:0; margin:0;" wire:ignore>
                                

                                <label class="text-muted"><input type="checkbox" name="checkDatepicker" id="checkDatepicker" class="float-left" style="z-index: 999999; height:20px;" value="value">&nbsp;<small>Filter by: Date</small></label>
                                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center;margin-top: -5px;" class="disabled">
                                    <i class="fa fa-calendar "></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down float-right"></i>
                                </div>
                            </div>

                            <div class="col-md-2 float-left " >
                                <label class="text-muted"><small>Filter by: Department / Project</small></label>

                                
                                {{-- <label for=""><small>Filter</small></label> --}}
                            <select wire:model= "filter_project" class="form-control text-center " style="height: 33px; font-size: 14px; margin-top: -5px;cursor:pointer;">
                                <option value="" >All</option>
                                @foreach ($projects as $project)
                                <option value="{{$project->id}}" >{{$project->project_name}}</option>
                                @endforeach
                            </select>
                            </div>
                       
                            <div class="col-md-2 float-left " style="margin-top: 20px;">
                                <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class=" mr-2 dropdown-toggle btn btn-outline-alternate">
                                    <span style="font-size: 14px;">Export / Download</span>
                                </button>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                                    <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">PDF</button>
                                    <button type="button" tabindex="0" class="dropdown-item">Excel</button>
                                
                                </div>
                            </div>
                            
                        
                        </div>
                        
                    {{-- date range picker data source  --}}
                       <input type="text" id="start" wire:model ="start" hidden>
                       <input type="text" id="end" wire:model ="end" hidden>
                        
                        {{-- <input type="text" name="dates" class="form-control"> --}}
                    </div>
                    <div class="nav nav-pills "  >
                                        
                        <div class="text-uppercase col-md-9 p-0" style="margin-bottom: -40px">
                               <div class="float-left">
                                <div class="btn btn-dark float-left d-flex mr-3" style="cursor: pointer;" data-toggle="modal" data-target="#payroll_modal"> 
                                    <i class="pe-7s-plus text-white pr-3"  style="font-size: 19px!important; ">
                                    </i>
                                    <span style="vertical-align: baseline; margin:auto; font-size:13px; padding-right:25px;" wire:click ="createMode()">New Payroll</span>
                                </div>   
                              
                               </div>
                                <div class="float-left ">
                                    
                                    <a wire:click="allPayrolls()" class="nav-link {{$allMode ? 'active' : ''}}">
                                    <span>All</span>
                                    <div class="badge badge-pill {{$allMode ? 'badge-light' : 'badge-primary'}}">{{$payrollCounts}}</div>
            
                                    </a>
                                </div>
                                <div class="float-left">

                                    <a wire:click="approvedPayrolls()" class="nav-link {{$approvedMode ? 'active' : ''}}">
                                <span>Approved / Printed</span>
                                        <div class="badge badge-pill {{$approvedMode ? 'badge-light' : 'badge-primary'}}">{{$approvedCounts}}</div>
                                    </a>
                                </div>
                                <div class="float-left">

                                    <a wire:click="pendingPayrolls()" class="nav-link {{$pendingMode ? 'active' : ''}}"><span>Pending</span>
                                        <div class="badge badge-pill badge-danger">{{$pendingCounts}}</div>
                                    </a>
                                </div>
                                    
                            {{-- <a disabled="" href="javascript:void(0);" class="nav-link disabled">
                                <i class="nav-link-icon pe-7s-box1"> </i><span>Disabled Link</span>
                            </a> --}}
                        </div>
                        <div class="col-md-3">
                                <div class="search-wrapper float-right  active ">
                                    <div class="input-holder ">
        
                                        <input type="text" class="search-input col-sm-12 col-md-12" wire:model="searchTerm" placeholder="Type to search">
        
                                        <button class="search-icon"><span></span></button>
                                    </div>
                                </div>
                        </div>
                    </div>
                  
                    </div>
                    {{-- <button class="mb-4  border-0 btn-transition btn btn-outline-light" style="margin-top: -20px;">Select All</button> --}}
                                <div class="card-body p-0 mb-2">
                                    
                                    <div style="margin: auto; width:100%; text-align:center; justify-content:center; position:absolute; top: 45%; 
                                    left: 8%; z-index: 999999;" wire:loading>
                                        <img width="200px" src="{{asset('assets/images/loader.gif')}}" alt="">
                                    </div>
                                    @if ($payrolls->count() < 1)
                                    <div class="card" style="margin-top: -15px; opacity:0.7;"> 
                                    <div style=" width:100%; text-align:center; " class="bg-white">
                                      <img style="height: 100%" src="{{asset('assets/images/no_result.gif')}}" alt="">

                                      {{-- <h3 style="position: relative;top:12vh">No results found.</h3> --}}
                                      
                                    </div>
                                </div>
                                    @endif
                                    <ul class="list-group" style="margin-top: -18px;">
                                        
                                        @foreach ($payrolls as $payroll)

                                        <li class="list-group-item">
                                            <div class="todo-indicator bg-success"></div>
                                            <div class="widget-content p-2">
                                                <div class="widget-content-wrapper">
                                                    {{-- <div class="widget-content-left mr-2">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" id="exampleCustomCheckbox3" class="custom-control-input">
                                                            <label class="custom-control-label" for="exampleCustomCheckbox3">&nbsp;</label>
                                                        </div>
                                                    </div> --}}
                                                    
                                                    <div class="widget-content-left mr-2" style="min-width: 300px">
                                                        <div class="custom-checkbox custom-control">
                                                            <div class="widget-heading">{{ucwords($payroll->payroll_description)}}
                                                           <span class="text-muted" style="font-size: 12px;"> #{{$payroll->id}}</span>

                                                            </div>
                                                            <div class="widget-subheading">
                                                                {{Carbon\Carbon::parse($payroll->payroll_from_date)->format('F d, Y') .' - '.Carbon\Carbon::parse($payroll->payroll_to_date)->format('F d, Y') }}
                                                            </div> 
                                                            
                                                                <div class="badge  
                                                                @if ($payroll->payroll_status == "approved")
                                                                    badge-info
                                                                    @elseif($payroll->payroll_status == "paid")
                                                                    badge-success
                                                                    @elseif($payroll->payroll_status == "pending")
                                                                    badge-warning
                                                                    @elseif($payroll->payroll_status == "cancelled")
                                                                    badge-danger
                                                                @endif
                                                                     mr-2" style="margin:0 !important;" >{{$payroll->payroll_status}}
                                                                    </div> &nbsp;&nbsp;
                                                                    |
                                                            <span class="badge text-muted"> 
                                                                @if ($payroll->project_id)
                                                                {{$payroll->projects->project_name}}
                                                                @else
                                                                All Department / Projects
                                                                @endif
                                                               
                                                            </span>
                                                           
                                                             
                                                        </div>
                                                    </div>
                                                    {{-- @if ($payroll->payroll_status != "pending")
                                                    <div class="widget-content-right mr-2 ">
                                                        <div class="card widget-chart text-left px-5 py-2">
                                                          
                                                            <div class="widget-chart-content text-center" style="min-width: 150px; max-width: 150px;">
                                                                <div class="widget-subheading text-dark" >Pay Run</div>
                                                                <div class="widget-numbers text-success" style="font-size: 20px;">{{number_format($payroll->payrolls->sum(function ($item) {
                                                                    return $item->total_net_pay > 0 ? $item->total_net_pay : 0;
                                                                }),2)}}</div>
                                                             
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif --}}

                                                    <div class="widget-content-right">
                                                        <div class="widget-content-wrapper">
                                                                
                                                            <div class="widget-content-right ">
                                                           
                                                        <div class="dropleft d-inline-block">
                                                          
                                                           
                                                            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link btn-transition  text-primary">&nbsp; Action</button>
                                                            </button>
                                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu" style="">
                                                                <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                                @if (!$payroll->approved_by && Auth::user()->role == "superadmin" && $payroll->payroll_status == "pending")
                                                                <button type="button" tabindex="0" class="dropdown-item bg-primary text-white" wire:click.prevent="$emit('approvedPayroll',{{$payroll->id}})">
                                                                    <i class=" pe-7s-like2 text-white"> </i><span class="ml-3">Approved</span>
                                                                </button>
                                                                @endif
                                                                @if ($payroll->approved_by  && $payroll->payroll_status == "approved")
                                                                <button type="button" tabindex="0" class="dropdown-item bg-success text-white" wire:click.prevent="$emit('markPaid',{{$payroll->id}})">
                                                                    <i class=" pe-7s-check text-white"> </i><span class="ml-3">Mark as Paid</span>
                                                                </button>
                                                                @endif
                                                            
                                                                @if ($payroll->approved_by  && $payroll->payroll_status == "approved")
                                                                <button type="button" tabindex="0" class="dropdown-item bg-secondary text-white" wire:click.prevent="$emit('withrawPayroll',{{$payroll->id}})">
                                                                    <i class=" pe-7s-check text-white"> </i><span class="ml-3">Withdraw Approval</span>
                                                                </button>
                                                                @endif
                                                                @if ($payroll->approved_by  && $payroll->payroll_status == "paid")
                                                                <button type="button" tabindex="0" class="dropdown-item bg-danger text-white" wire:click.prevent="$emit('revertPayroll',{{$payroll->id}})">
                                                                    <i class=" pe-7s-check text-white"> </i><span class="ml-3">Revert</span>
                                                                </button>
                                                                @endif

                                                                <a type="button" tabindex="0" class="dropdown-item" href="{{route('admin.list-payrolls.view',$payroll->id)}}">
                                                                    <i class=" pe-7s-look"> </i><span  class="ml-3">View</span>
                                                                </a>
                                                                @if ($payroll->payroll_status != "pending" and $payroll->payroll_status)
                                                                <button type="button" tabindex="0" class="dropdown-item" wire:click="bulkPayslipPDF({{$payroll->id}})">
                                                                    <i class="pe-7s-print"> </i><span  class="ml-3">Generate Payslips</span>
                                                                </button>
                                                                @endif
                                                               
                                                                <button type="button"  data-toggle="modal" data-target='#payroll_modal'class="dropdown-item" wire:click="edit({{$payroll->id}})">
                                                                    <i class=" pe-7s-settings"></i><span class="ml-3">Edit</span>
                                                                </button>
                                                                <button type="button" tabindex="0" class="dropdown-item" wire:click.prevent="$emit('deletePayroll',{{$payroll}})">
                                                                    <i class=" pe-7s-trash"> </i><span  class="ml-3" >Delete</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            {{-- </div> --}}
                                  <div class="justify-content-center">
                                    {{$payrolls->links('pagination')}}
    
                                  </div>
                                </div>
            </div>
        </div>
    
        <script type="text/javascript">

            $(function() {
             
                var start = moment();
                var end = moment();
                var checkBox = document.getElementById("checkDatepicker");

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
                @this.on('deletePayroll', id => {
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

                @this.on('approvedPayroll', id => {
                    Swal.fire({
                    title: 'Approve this Payroll?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Approve',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                        //if user clicks on delete
                        if (result.value) {
                            // calling destroy method to delete
                            @this.call('approved',id)
                           
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Approving Payroll cancelled :)',
                                'error'
                            )
                        }
                    });
                })

                @this.on('markPaid', id => {
                    Swal.fire({
                    title: 'Mark as Paid?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Approve',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                        //if user clicks on delete
                        if (result.value) {
                            // calling destroy method to delete
                            @this.call('markPaid',id)
                           
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Approving Payroll cancelled :)',
                                'error'
                            )
                        }
                    });
                })

                
                @this.on('withrawPayroll', id => {
                    Swal.fire({
                    title: 'Withraw Approval?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Approve',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                        //if user clicks on delete
                        if (result.value) {
                            // calling destroy method to delete
                            @this.call('withrawPayroll',id)
                           
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Approving Payroll cancelled :)',
                                'error'
                            )
                        }
                    });
                })

                @this.on('revertPayroll', id => {
                    Swal.fire({
                    title: 'Withraw Approval?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Approve',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                        //if user clicks on delete
                        if (result.value) {
                            // calling destroy method to delete
                            @this.call('revertPayroll',id)
                           
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Approving Payroll cancelled :)',
                                'error'
                            )
                        }
                    });
                })




            })
        </script>
        
    </div>
    
    