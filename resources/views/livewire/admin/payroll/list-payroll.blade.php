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
       
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-paper-plane text-success">
                            </i>
                        </div>
                        <div>Payrolls
                            <div class="page-title-subheading">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde labore eaque blanditiis officia quia nulla..
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
            @if (!$summaryMode)
        
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
                                                <div class="col-md-4 ">
                                                <h4 class="card-title">List of Payrolls</h4>
                                                
                                                </div>
                                                <div class="col-md-12 float-right">
                                                    {{-- <div class="dropdown  float-left">
                                                        <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-alternate">Export / Download</button>
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                                                            <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">PDF</button>
                                                            <button type="button" tabindex="0" class="dropdown-item">Excel</button>
                                                          
                                                        </div>
                                                    </div> --}}
                                                    <div class="search-wrapper active float-right">
                                                        <div class="input-holder ">
    
                                                            <input type="text" class="search-input " wire:model="searchTerm" placeholder="Type to search">
    
                                                            <button class="search-icon"><span></span></button>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            <div class=" table-responsive " style="height: 325px;">
                                                
                                   <table  class="table table-striped table-bordered table-hover" id="position-table" >
                                    
                                    <thead>
                                        <tr>
                                            <th width="200px">ID</th>
                                            <th>Payroll Description</th>

                                            <th>From <small>(Date)</small></th>
                                            <th>To <small>(Date)</small></th>
                                            <th>Status</th>
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
                                            <td>{{Carbon\Carbon::parse($payroll->payroll_from_date)->format('F d, Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($payroll->payroll_to_date)->format('F d, Y')}}</td>
                                            <td>{{ucwords($payroll->payroll_status)}}</td>
                                            <td class="text-center d-flex flex-center justify-content-center">
                                                
                                               


                                            <div class="dropdown d-inline-block">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>

                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu" style="">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                    @if (!$payroll->approved_by && Auth::user()->role == "superadmin" && $payroll->payroll_status == "pending")
                                                    <button type="button" tabindex="0" class="dropdown-item bg-success text-white" wire:click="$emit('approvedPayroll',{{$payroll->id}})">
                                                        <i class=" pe-7s-like2 text-white"> </i><span class="ml-3">Approved</span>
                                                    </button>
                                                    @endif
                                                    <button type="button" tabindex="0" class="dropdown-item" wire:click="payrollSummary({{$payroll->id}})">
                                                        <i class=" pe-7s-look"> </i><span  class="ml-3">View</span>
                                                    </button>
                                                    <button type="button" tabindex="0" class="dropdown-item" wire:click="payrollSummary({{$payroll->id}})">
                                                        <i class="pe-7s-print"> </i><span  class="ml-3">Generate Payslips</span>
                                                    </button>
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
                
            </div>
            @elseif($payroll_status != "printed")
            @include('livewire.admin.payroll.preview-payroll')
            @elseif($payroll_status == "printed")
            @include('livewire.admin.payroll.summary-payroll')


            @endif
            
        </div>
            
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
    
    