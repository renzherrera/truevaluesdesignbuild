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
                @if($listMode)
                
                @endif
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon bg-primary">
                            <i class="pe-7s-paint text-white">
                            </i>
                        </div>
                        <div class="">Projects &nbsp;&nbsp;&nbsp;
                            <div class="page-title-subheading ">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde labore eaque blanditiis officia quia nulla..
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        
            @if ($createMode)
                
            @include('livewire.admin.project.create-project')


            @elseif($updateMode)

            @include('livewire.admin.project.edit-project')


            @else

          
            <div class="tab-content">
                
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="form-row mb-2">
                        
                      
                    </div>
                    <div class="main-card card ">
                        <div class="card-body">
    
                                        {{-- {{ $dataTable->table() }} --}}
                                <div class="col-sm-12  date-filter" style="width: 100%">
                                            
                                            <div class="form-row ">
                                                <div class="col-md-4 ">
                                                <h4 class="card-title">List of Positions</h4>
                                                
    
                                                    {{-- <div class="form-row input-daterange">
                                                        <div class="form-group col-md-5 ">
                                                            <input style="cursor: pointer; font-size: 13px;" type="text" id="from_date" name="from_date" class="form-control datepicker" placeholder="From Date" readonly>
                                                        </div>
                                                        <div class="form-group col-md-5">
                                                            <input style="cursor: pointer; font-size: 13px;" type="text" id="to_date"  name="to_date" class="form-control datepicker" placeholder="To Date" readonly>
            
                                                        </div>
                                                      
                                                        <div class="form-group col-md-2 " id="">
                                                        <button type="button" class="btn btn-info form-control" id="filter" name="filter">Filter</button>
                                                        </div>
                                                        
                                                        
                                                    </div> --}}
                                                </div>
                                                
                                                <div class="col-md-12 float-right inline-block">
                                                        <div class="btn btn-dark float-left d-flex mr-3" wire:click="createMode()"> 
                                                            <i class="pe-7s-plus text-white pr-3"  style="font-size: 20px!important; ">
                                                            </i>
                                                            <span style="vertical-align: baseline; margin:auto; font-size:14px; padding-right:25px;">New Project</span>
                                                        </div>
                                                    <div class="dropdown  float-left">
                                                        
                                                        <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-alternate">
                                                            <span style="font-size: 14px;">Export / Download</span>
                                                        </button>
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                                                            <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">PDF</button>
                                                            <button type="button" tabindex="0" class="dropdown-item">Excel</button>
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="search-wrapper  active float-right">
                                                        <div class="input-holder ">
    
                                                            <input type="text" class="search-input " wire:model="searchTerm" placeholder="Type to search">
    
                                                            <button class="search-icon"><span></span></button>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            <div class=" table-responsive " style="height: 100%">
                                                
                                   <table  class="table table-striped table-bordered" id="position-table" >
                                    
                                    <thead>
                                        <style>
                                            .text-xs
                                            {
                                                font-size: .69rem !important;
                                                font-weight: 300;

                                            }
                                            .text-sm
                                            {
                                                font-size: .875rem !important;
                                                font-weight: 500;
                                            }
                                            .media-body
                                            {
                                                flex: 1 1;
                                            }
                                        </style>
                                        <tr>
                                            <th >Project Name</th>
                                            <th>Owner</th>
                                            <th >Project Budget <small>(ESTIMATED)</small></th>
                                            <th>Service Type</th>
                                            <th class="text-center">Status</th>

                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if($projects->count() < 1)
                                            <tr><td colspan="4" class="text-center"><h4>No projects found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($projects as $project)
                                        <tr>
                                           
                                            <td>
                                                <div class="media-body flex items-center">
                                                    <h2 class="name mb-0 text-sm">{{$project->project_name}}</h2>
                                                    <p class="text-xs mb-0">{{$project->project_location}}</p>

                                                </div>
                                            </td>
                                            <td>{{$project->project_owner}}</td>
                                            <td><span>&#8369; </span>{{number_format($project->estimated_budget,2)}}</td>
                                            <td>{{$project->project_type}}</td>
                                                @if ($project->project_status == "1")
                                                <td class="text-center">
                                                    <span class="badge badge-info text-xs"><small>Active</small></span>
                                                </td>
                                                @elseif ($project->project_status == "2")
                                                <td class="text-center">
                                                    <span class="badge badge-success text-xs"><small>Completed</small></span>
                                                </td>
                                                @elseif ($project->project_status == "3")
                                                <td class="text-center">
                                                    <span class="badge badge-warning text-xs"><small>Pending</small></span>
                                                </td>
                                                @elseif ($project->project_status == "4")
                                                <td class="text-center">
                                                    <span class="badge badge-secondary text-xs"><small>Stopped</small></span>
                                                </td>
                                                @endif    
                                            <td class="text-center"><div class="dropdown">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                        <button wire:click="edit({{$project->id}})" tabindex="0" class="dropdown-item">Edit</button>
                                                    
                                                    <button wire:click.prevent="$emit('deletePosition',{{$project}})" class="dropdown-item" type="button"> Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                                  <div class="card-footer justify-content-center">
                                    {{$projects->links('pagination')}}
    
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
        
    </div>
    
    
    