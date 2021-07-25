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
                            <div class="page-title-subheading">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde labore eaque blanditiis officia quia nulla..
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
            @if ($listMode)
        
                @if ($updateMode)
                @include('livewire.admin.payroll.edit-payroll')
                @else
                @include('livewire.admin.payroll.create-payroll')
                @endif

            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    
                    <div class="main-card card ">
                        <div class="card-body">
    
                                <div class="col-sm-12  date-filter" style="width: 100%">
                                            
                                            <div class="form-row ">
                                                <h4 class="card-title float-left">List of Payrolls    </h4>
                                                    
                                                <div class="col-md-12 float-right inline-block">
                                                    
                                                <div class="dropdown  float-left">
                                                    
                                                    <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-alternate">
                                                        <span style="font-size: 14px;">Export / Download</span>
                                                    </button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                                                        <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">PDF</button>
                                                        <button type="button" tabindex="0" class="dropdown-item">Excel</button>
                                                      
                                                    </div>
                                                    
                                                </div>

                                                <div class="col-md-3 float-left" wire:ignore>
                                                <input type="checkbox" name="checkDatepicker" id="checkDatepicker" class="float-left" style="z-index: 999999">


                                                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center" class="disabled">
                                                        <i class="fa fa-calendar "></i>&nbsp;
                                                        <span></span> <i class="fa fa-caret-down float-right"></i>
                                                    </div>
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

                                               
                                                
                                                
                                                {{-- <input type="text" name="dates" class="form-control"> --}}
                                             
                                            </div>
                                            <div class=" table-responsive " style="height: 325px;">
                                                
                                   <table  class="table table-striped table-bordered table-hover" id="position-table" >
                                 
                                    <thead>
                                        <tr>
                                            <th width="200px">ID</th>
                                            <th>Payroll Title</th>
                                            <th class="text-center">Payroll Date</th>
                                            <th class="text-center">Project / Department</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if($payrolls->count() < 1)
                                            <tr><td colspan="6" class="text-center"><h4>No payroll data found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($payrolls as $payroll)
                                        <tr>
                                            <td>{{$payroll->id}}</td>
                                            <td>{{$payroll->payroll_description}}</td>
                                            <td class="text-center">{{Carbon\Carbon::parse($payroll->payroll_from_date)->format('F d, Y') .' - '.Carbon\Carbon::parse($payroll->payroll_to_date)->format('F d, Y') }}</td>
                                            <td class="text-center">
                                                @if ($payroll->project_id)
                                                {{$payroll->projects->project_name}}
                                                @else
                                                All
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge mr-2  badge-sm badge-pill
                                                @if ($payroll->payroll_status == "approved")
                                                badge-success
                                                @elseif($payroll->payroll_status == "printed")
                                                badge-primary
                                                @elseif($payroll->payroll_status == "pending")
                                                badge-warning
                                                @endif
                                                ">{{ucwords($payroll->payroll_status)}}
                                                </span>
                                            </td>
                                            <td class="text-center justify-content-center">
                                            <div class="dropdown d-inline-block">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>

                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu" style="">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                    @if (!$payroll->approved_by && Auth::user()->role == "superadmin" && $payroll->payroll_status == "pending")
                                                    <button type="button" tabindex="0" class="dropdown-item bg-success text-white" wire:click.prevent="$emit('approvedPayroll',{{$payroll->id}})">
                                                        <i class=" pe-7s-like2 text-white"> </i><span class="ml-3">Approved</span>
                                                    </button>
                                                    @endif
                                                    {{-- <button type="button" tabindex="0" class="dropdown-item" wire:click="payrollSummary({{$payroll->id}})">
                                                        <i class=" pe-7s-look"> </i><span  class="ml-3">View</span>
                                                    </button> --}}
                                                    <a type="button" tabindex="0" class="dropdown-item" href="{{route('admin.list-payrolls.view',$payroll->id)}}">
                                                        <i class=" pe-7s-look"> </i><span  class="ml-3">View</span>
                                                    </a>
                                                    @if ($payroll->payroll_status != "pending" and $payroll->payroll_status)
                                                    <button type="button" tabindex="0" class="dropdown-item" wire:click="bulkPayslipPDF({{$payroll->id}})">
                                                        <i class="pe-7s-print"> </i><span  class="ml-3">Generate Payslips</span>
                                                    </button>
                                                    @endif
                                                   
                                                    <button type="button" tabindex="0" class="dropdown-item" wire:click="edit({{$payroll->id}})">
                                                        <i class=" pe-7s-settings"></i><span class="ml-3">Edit</span>
                                                    </button>
                                                    <button type="button" tabindex="0" class="dropdown-item" wire:click.prevent="$emit('deletePayroll',{{$payroll}})">
                                                        <i class=" pe-7s-trash"> </i><span  class="ml-3" >Delete</span>
                                                    </button>
                                                </div>
                                            </div>

                                            </div></td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                                  <div class="card-footer justify-content-center">
                                    {{$payrolls->links('pagination')}}
    
                                  </div>
                                </div>
    
                                
                               
                            </div>
    
                            
                        </div>
        
                    </div>
        
                
            </div>
            @elseif($summaryMode)
            @include('livewire.admin.payroll.summary-payroll')
            @elseif($previewMode)
            @include('livewire.admin.payroll.preview-payroll')
           
            @endif
            
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





            })
        </script>
        
    </div>
    
    