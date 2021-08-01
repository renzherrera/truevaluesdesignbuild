<div>
    
    <title>List of User | True Values</title>
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
                        <div class="page-title-icon bg-primary">
                            <i class="pe-7s-users text-white">
                            </i>
                        </div>
                        <div>List of Users
                            <div class="page-title-subheading">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Non, aliquid.
                            </div>
                        </div>
                    </div>
                </div>
            </div>           

            <div class="tab-content">
                    
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    
                    <div class="main-card card " >
                        <div class="card-body" style="overflow-x: auto !important;">
    
                                        {{-- {{ $dataTable->table() }} --}}
                                <div class="col-sm-12  date-filter" >
                                            
                                            <div class="form-row ">
                                                <div class="col-md-4">
                                                <h4 class="card-title">List of Users</h4>
                                                
                                                </div>
                                                
                                                <div class="col-md-12 float-right inline-block text-white">
                                                        <a class="btn btn-primary  float-left d-flex mr-3" href="{{route('admin.list-users.register')}}"> 
                                                            <i class="pe-7s-plus text-white pr-3"  style="font-size: 20px!important; ">
                                                            </i>
                                                            <span style="vertical-align: baseline; margin:auto; font-size:14px; padding-right:25px;">New User</span>
                                                        </a>
                                                    
                                                    {{-- <input type="file" name="importExcelFile" id="" wire:model.defer="importExcelFile"> --}}
                                                    <div class="search-wrapper  active float-right">
                                                        <div class="input-holder ">
    
                                                            <input type="text" class="search-input " wire:model="searchTerm" placeholder="Type to search">
    
                                                            <button class="search-icon"><span></span></button>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            <div style="margin: auto; width:100%; text-align:center; justify-content:center;" wire:loading>
                                                <img width="250px" src="{{asset('assets/images/loader.gif')}}" alt="">
                                            </div>         
                                            
                                   <table  class="table table-striped mt-2" wire:loading.remove>
                                    
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
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th class="text-center">Status</th>
    
                                            <th class="text-center" width="150px">Action</th>
                                        </tr>
    
                                    </thead>
                                    <tbody>
                                        @if($users->count() < 1)
                                            <tr><td colspan="11" class="text-center"><h4>No employee data found</h4></td></tr>
                                        
                                        @endif
                                        @foreach ($users as $user)
                                        <tr>
                                           <td>
    
                                            <div class="rounded-circle bg-red" 
                                            style="position: relative;
                                            width: 42px;
                                            height: 42px;
                                            overflow: hidden;
                                            border-radius: 50%;
                                            display: block; text-align:center; "  >
                                                <a href="#" class="flex-center" data-toggle="tooltip" >
                                                    @if ($user->image)
                                                    <img style=" width: 42px;
                                                    height: auto; margin:auto;"  alt="Image placeholder" src="{{ asset("storage/user_images/". $user->image)}}">
                                                    @else
                                                    <img style=" width: 42px;
                                                    height: auto; margin:auto;"  alt="Image placeholder" src="{{ asset("storage/images/user_100px.png")}}">
                                                    @endif
                                                 
                                               </a>
                                              </div>
    
                                           </td>
                                            <td>
                                                <div class="media-body flex items-center">
                                                    <h2 class="name mb-0 text-sm">{{$user->name}}</h2>
                                            
    
                                                </div>
                                            </td>
                                            <td>{{$user->email}}</td>
                                            <td>{{ucwords($user->role)}}</td>
                                            <td class="text-center">
                                            @if ($user->status == true)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                            </td>

                                            <td class="text-center"><div class="dropdown">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-link"></button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="z-index: 999999;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                                    <h6 tabindex="-1" class="dropdown-header">Actions</h6>
                                                        <a href="{{route('admin.list-users.edit',[$user])}}" tabindex="0" class="dropdown-item">Edit</a>
                                                    
                                                    <button wire:click.prevent="$emit('deleteUser',{{$user}})" class="dropdown-item" type="button"> Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                                  <div class="card-footer justify-content-center">
                                    {{$users->links('pagination')}}
    
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
            @this.on('deleteUser', id => {
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
    
        
        
        
    