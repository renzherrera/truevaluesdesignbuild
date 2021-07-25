


<div>

    <title>List of Services | True Values</title>
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
        .app-page-title{
        }
       
      
      </style>
    </head>
    
       
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon bg-warning">
                            <i class="pe-7s-date text-white">
                            </i>
                        </div>
                        <div>Services
                            <div class="page-title-subheading">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde labore eaque blanditiis officia quia nulla..
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        
             @if ($updateMode)
                
            @include('livewire.admin.service.edit-service')
            @elseif($createMode)
            @include('livewire.admin.service.create-service') 
            @else
            
                
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    
                    <div class="main-card card ">
                        <div class="card-body">
    
                                        {{-- {{ $dataTable->table() }} --}}
                                <div class="col-sm-12  date-filter" style="width: 100%">
                                            
                                            <div class="form-row ">
                                                <div class="col-md-4 ">
                                                <h4 class="card-title">List of Services</h4>
                                                                      
                                                </div>
                                                
                                                <div class="col-md-12 float-right">
                                                    <button type="button" wire:click="createMode()" class="mb-2 mr-2 btn btn-dark float-left">
                                                        New Service</button>

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
                                            <div class=" table-responsive " style="height: 100%;">
                                                
                                   <table  class="table table-striped table-bordered" id="position-table" >
                                    
                                    <thead>
                                        <tr>
                                            <th width="200px">Position Title</th>
                                            <th>Job Description</th>
                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if($services->count() < 1)
                                            <tr><td colspan="4" class="text-center"><h4>No service found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($services as $service)
                                        <tr>
                                           
                                            <td>{{$service->service_name}}</td>
                                            <td>{{$service->service_description}}</td>
                                            
                                            <td class="text-center"><div class="dropdown">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                        <button wire:click="edit({{$service->id}})" tabindex="0" class="dropdown-item">Edit</button>
                                                    
                                                    <button wire:click.prevent="$emit('deletePosition',{{$service}})" class="dropdown-item" type="button"> Delete</button>
                                                </div>
                                            </div></td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                                  <div class="card-footer justify-content-center">
                                    {{$services->links('pagination')}}
    
                                  </div>
                                </div>
    
                                
                               
                            </div>
    
                            
                        </div>
        
                    </div>
        
                </div>
                
            </div>
            @endif 

        </div>
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
                            Swal.fire(
                                'Deleted!',
                                'Data has been deleted.',
                                'success'
                            )
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


{{-- MODAL --}}

        
    </div>
    
    
    