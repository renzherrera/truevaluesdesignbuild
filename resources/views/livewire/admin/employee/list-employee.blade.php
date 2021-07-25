<div>
@include('livewire.admin.employee.webcam-modal')
@if (!$createMode)
<title>List of Employees | True Values</title>
    
@endif
<style>
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
<div>
   
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon bg-success">
                        <i class="pe-7s-users  text-white">
                        </i>
                    </div>
                    <div>New Employee
                        <div class="page-title-subheading">All fields are required to fill.
                        </div>
                    </div>
                </div>
            </div>
        </div>           
    
        @if ($createMode)
        @include('livewire.admin.employee.create-employee')
        @elseif ($updateMode)
        @include('livewire.admin.employee.edit-employee')

        @else
        <div class="tab-content">
                
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                
                <div class="main-card card " >
                    <div class="card-body" style="overflow-x: auto !important;">

                                    {{-- {{ $dataTable->table() }} --}}
                            <div class="col-sm-12  date-filter" >
                                        
                                        <div class="form-row ">
                                            <div class="col-md-4">
                                            <h4 class="card-title">List of Employees</h4>
                                            

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
                                                        <span style="vertical-align: baseline; margin:auto; font-size:14px; padding-right:25px;">New Employee</span>
                                                    </div>
                                                <div class="dropdown  float-left">
                                                    
                                                    <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-alternate">
                                                        <span style="font-size: 14px;">Export / Download</span>
                                                    </button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-7px, 33px, 0px);">
                                                        <button type="button" tabindex="0" class="dropdown-item" wire:click="createPDF()">PDF</button>
                                                        <button type="button" tabindex="0" class="dropdown-item">Excel</button>
                                                        {{-- <button type="button" tabindex="0" class="dropdown-item" wire:click.prevent="import">Import Excel</button> --}}
                                                      
                                                    </div>
                                                </div>
                                                {{-- <input type="file" name="importExcelFile" id="" wire:model.defer="importExcelFile"> --}}
                                                <div class="search-wrapper  active float-right">
                                                    <div class="input-holder ">

                                                        <input type="text" class="search-input " wire:model="searchTerm" placeholder="Type to search">

                                                        <button class="search-icon"><span></span></button>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                               <table  class="table table-striped mt-2"  style=""   >
                                
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
                                        <th>Image</th>
                                        <th>Employee Name</th>
                                        <th>Contact #</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Salary <small>(per Day)</small></th>
                                        <th>Schedule</th>
                                        <th>Address</th>
                                        <th>Designated</th>
                                        <th class="text-center">Status</th>

                                        <th class="text-center" width="150px">Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @if($employees->count() < 1)
                                        <tr><td colspan="11" class="text-center"><h4>No employee data found</h4></td></tr>
                                    
                                    @endif
                                    @foreach ($employees as $employee)
                                    <tr>
                                       <td>

                                        <div class="rounded-circle bg-red" 
                                        style="position: relative;
                                        width: 42px;
                                        height: 42px;
                                        overflow: hidden;
                                        border-radius: 50%;
                                        display: block; text-align:center; "  >
                                        @if ($employee->image)
                                            <a href="#" class="flex-center" data-toggle="tooltip" >
                                              <img style=" width: 42px;
                                              height: auto; margin:auto;"  alt="Image placeholder" src="{{ asset("storage/employee_images/". $employee->image)}}">
                                           </a>
                                        @else
                                        <a href="#" class="flex-center" data-toggle="tooltip" >
                                            <img style=" width: 42px;
                                            height: auto; margin:auto;"  alt="Image placeholder" src="{{ asset("storage/images/user_100px.png")}}">
                                         </a>
                                        @endif

                                          </div>

                                       </td>
                                        <td>
                                            <div class="media-body flex items-center">
                                                <h2 class="name mb-0 text-sm"><strong>{{$employee->first_name .' '. $employee->middle_name.' '. $employee->last_name}}</strong></h2>
                                                <p class="text-xs mb-0">{{$employee->position->position_title}}</p>

                                            </div>
                                        </td>
                                        <td>{{$employee->contact}}</td>
                                        <td>{{$employee->date_of_birth}}</td>
                                        <td>{{ucwords($employee->gender)}}</td>
                                       
                                        <td><span>&#8369; </span>{{number_format($employee->position->salary_rate,2)}}</td>
                                        <td>{{ Carbon\Carbon::parse($employee->schedule->start_time)->format('g:i:A').' - '. Carbon\Carbon::parse($employee->schedule->end_time)->format('g:i:A')}}</td>
                                        <td>{{$employee->address}}</td>
                                        {{-- <td><span>&#8369; </span>{{number_format($project->estimated_budget,2)}}</td> --}}
                                        @if($employee->project)
                                        <td>{{$employee->project->project_name}}</td>
                                        @else
                                        <td></td>
                                        @endif
                                            @if ($employee->status == "1")
                                            <td class="text-center">
                                                <span class="badge badge-info text-xs"><small>Active</small></span>
                                            </td>
                                            @else
                                            <td class="text-center">
                                                <span class="badge badge-secondary text-xs"><small>Inactive</small></span>
                                            </td>
                                            @endif    
                                        <td class="text-center"><div class="dropdown">
                                            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                    <button wire:click="edit({{$employee->id}})" tabindex="0" class="dropdown-item">Edit</button>
                                                
                                                <button wire:click.prevent="$emit('deleteEmployee',{{$employee}})" class="dropdown-item" type="button"> Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                    </tr>    
                                    @endforeach
                                    
                                </tbody>
                            </table>
                              <div class="card-footer justify-content-center">
                                {{$employees->links('pagination')}}

                              </div>
                            </div>

                            
                           
                        </div>

                        
                    </div>
    
                </div>
    
            

        @endif









        



        
            
        
    </div>





            
    
   
</div>
<script>
    document.addEventListener('livewire:load', function () {
        @this.on('deleteEmployee', id => {
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
@include('livewire.admin.employee.edit-webcam-modal')

    
    
    
