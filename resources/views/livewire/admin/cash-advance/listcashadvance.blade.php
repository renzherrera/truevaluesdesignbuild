<div>
    <title>List of Positions | True Values</title>
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
                        <div class="page-title-icon bg-success">
                            <i class="pe-7s-users  text-white">
                            </i>
                        </div>
                        <div>Cash Advance
                            <div class="page-title-subheading">All fields are required to fill.
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        
            @if ($updateMode)
            @include('livewire.admin.cash-advance.edit-cashadvance')
            @elseif ($createMode)
            @include('livewire.admin.cash-advance.create-cashadvance')
    
            @endif
            
                
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    
                    <div class="main-card card ">
                        <div class="card-body">
                                
                                <div class="col-sm-12  date-filter" style="width: 100%">
                                            
                                            <div class="form-row ">
                                                <div class="col-md-4 ">
                                                <h4 class="card-title">List of Cash Advances</h4>
    
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
                                                
                                   <table  class="table table-striped table-bordered" id="position-table" >
                                    
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th width="150px;" class="text-center">Status</th>
                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if($cashadvances->count() < 1)
                                            <tr><td colspan="100%" class="text-center"><h4>No data found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($cashadvances as $cashadvance)
                                        <tr>
                                           
                                            <td>{{ucwords($cashadvance->employees->first_name). ' ' .ucwords($cashadvance->employees->middle_name). ' ' . ucwords($cashadvance->employees->last_name)}}</td>
                                            <td><span>&#8369; </span>{{number_format($cashadvance->cash_amount,2)}}</td>
                                            <td>{{ Carbon\Carbon::parse($cashadvance->requested_date)->format('F d, Y') }}</td>
                                            <td class="text-center">
                                            @if ($cashadvance->status == "pending")
                                               <div class="mb-2 mr-2 badge  badge-pill badge-secondary">{{ucwords($cashadvance->status)}}</div>
                                            @elseif ($cashadvance->status == "approved")
                                              <div class="mb-2 mr-2 badge  badge-pill badge-primary">{{ucwords($cashadvance->status)}}</div>
                                            @elseif($cashadvance->status == "paid")
                                              <div class="mb-2 mr-2 badge  badge-pill badge-success">{{ucwords($cashadvance->status)}}</div>
                                            @endif
                                             </td>
                                            <td class="text-center">
                                                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
    
                                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu" style="">
                                                        <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                        @if (!$cashadvance->approved_by && Auth::user()->role == "superadmin" && $cashadvance->status == "pending")
                                                        <button type="button" tabindex="0" class="dropdown-item bg-success text-white" wire:click="$emit('approvedCashAdvance',{{$cashadvance->id}})">
                                                            <i class=" pe-7s-like2 text-white"> </i><span class="ml-3">Approved</span>
                                                        </button>
                                                        @endif
                                                    
                                                        <button type="button" tabindex="0" class="dropdown-item" wire:click="edit({{$cashadvance->id}})" >
                                                            <i class=" pe-7s-settings"></i><span class="ml-3">Edit</span>
                                                        </button>
                                                        <button type="button" tabindex="0" class="dropdown-item" wire:click.prevent="$emit('deleteCashadvance',{{$cashadvance}})" >
                                                            <i class=" pe-7s-trash"> </i><span  class="ml-3" >Delete</span>
                                                        </button>
                                                    </div>
                                                </td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                                  <div class="card-footer justify-content-center">
                                    {{$cashadvances->links('pagination')}}
    
                                  </div>
                                </div>
    
                                
                               
                            </div>
    
                            
                        </div>
        
                    </div>
        
                </div>
                
            </div>
        </div>
            
        <script>
            document.addEventListener('livewire:load', function () {
                @this.on('deleteCashadvance', id => {
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

                @this.on('approvedCashAdvance', id => {
                    Swal.fire({
                    title: 'Approve this cash advance?',
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
                                'Approving cash advance cancelled :)',
                                'error'
                            )
                        }
                    });
                })



            }) //end of js event listener
        </script>
        
    </div>
    
    
    