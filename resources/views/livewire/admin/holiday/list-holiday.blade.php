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
       
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-paper-plane text-success">
                            </i>
                        </div>
                        <div>Holidays
                            <div class="page-title-subheading">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde labore eaque blanditiis officia quia nulla..
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        
                @if ($updateMode)
                @include('livewire.admin.holiday.edit-holiday')
                @else
                @include('livewire.admin.holiday.create-holiday')
                @endif

            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    
                    <div class="main-card card ">
                        <div class="card-body">
    
                                <div class="col-sm-12  date-filter" style="width: 100%">
                                            
                                            <div class="form-row ">
                                                <div class="col-md-4 ">
                                                <h4 class="card-title">List of Holidays</h4>
                                                
                                                </div>
                                                <div class="col-md-12 float-right">
                                                    {{-- <div class="dropdown  float-left">
                                                        <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-alternate">Export / Download</button>
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                                                            <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">PDF</button>
                                                            <button type="button" tabindex="0" class="dropdown-item">Excel</button>
                                                          
                                                        </div>
                                                    </div> --}}
                                                    {{-- <div class="search-wrapper active float-right">
                                                        <div class="input-holder ">
    
                                                            <input type="text" class="search-input " wire:model="searchTerm" placeholder="Type to search">
    
                                                            <button class="search-icon"><span></span></button>
                                                        </div>
                                                    </div> --}}
                                                   
                                                </div>
                                            </div>
                                            <div class=" table-responsive " style="height: 325px;">
                                                
                                   <table  class="table table-striped table-bordered table-hover" id="position-table" >
                                    
                                    <thead>
                                        <tr>
                                            <th width="200px">ID</th>
                                            <th>Holiday Name</th>
                                            <th>Rate</th>
                                            <th>Overtime Rate</th>
                                            <th>Date</th>
                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if($holidays->count() < 1)
                                            <tr><td colspan="6" class="text-center"><h4>No holidays data found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($holidays as $holiday)
                                        <tr>
                                            <td>{{$holiday->id}}</td>
                                            <td>{{$holiday->holiday_name}}</td>
                                            <td>{{$holiday->rate}}</td>
                                            <td>{{$holiday->ot_rate}}</td>
                                            <td>{{Carbon\Carbon::parse($holiday->date)->format('F d, Y')}}</td>
                                            <td class="text-center d-flex flex-center justify-content-center">
                                                
                                            <div class="dropdown d-inline-block">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>

                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu" style="">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                   
                                                    <button type="button" tabindex="0" class="dropdown-item" wire:click="edit({{$holiday->id}})">
                                                        <i class=" pe-7s-settings"></i><span class="ml-3">Edit</span>
                                                    </button>
                                                    <button type="button" tabindex="0" class="dropdown-item" wire:click.prevent="$emit('deleteHoliday',{{$holiday}})">
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
                                    {{$holidays->links('pagination')}}
    
                                  </div>
                                </div>
    
                                
                               
                            </div>
    
                            
                        </div>
        
                    </div>
        
                
            </div>

            
        </div>
            
        <script>
            document.addEventListener('livewire:load', function () {
                @this.on('deleteHoliday', id => {
                    Swal.fire({
                    title: 'Continue on saving this holiday?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Continue',
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
                                'Deleting holiday cancelled :)',
                                'error'
                            )
                        }
                    });
                })


            })
        </script>
        
    </div>
    
    