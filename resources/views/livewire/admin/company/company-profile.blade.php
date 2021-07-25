<div>
@if ($updateMode)
    @include('livewire.admin.company.edit-profile')
@else
<title>Profile - True Value Design & Build</title>
<style>
    p {
        font-weight: bold;
    }
    h6 {
        text-transform: uppercase;
    }
</style>
<div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-global icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Company Profile
                    <div class="page-title-subheading">This is an example dashboard created using build-in elements and components.
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="container-fluid mt--6">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header" >
                  <div class="col-md-6">
                    <h3 class="card-title">Company information </h3>
                  </div>
                  <div class="col-md-6">
                    <div class="float-right">
                        <button type="button" id="edit-profile" class="btn btn-sm btn-primary  text-right flex flex-end" wire:click="updateMode()">Edit Profile</button>
                        <button type="button" wire:click="$refresh" id="cancel-profile" class="btn btn-sm btn-danger  text-right flex flex-end" style="display: none">Cancel</button>
                        <button id="save-profile" wire:click.prevent="$emit('triggerUpdate')" class="btn btn-sm btn-primary  text-right flex flex-end" style="display: none">Apply Changes</button>
                      </div>
                  </div>
                    
              </div>
              @if($company)
              <div class="card-body">
                <form wire:submit.prevent="edit">
                  <input type="hidden" name="_token" value="y9L7xhY1D2wocvzx8Ed2QWL3Y7lnpRY3eAJU2WOG">             
                  <input type="hidden" wire.model.defer="company_id">
                  <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="image">Company Logo</label>
                                    </div>
                                  </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <img class="image-field" width="250px;" style="border-radius:5%;"src="{{asset('storage/images/'.$image)}}" alt="">
                                    </div>
                                  </div>
                            </div>
                            <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-control-label" for="input-username">Company Name</label>
                                <p class="label-field" >{{$company->company_name}}</p>
            
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-control-label" for="input-username">Nature of Business</label>
                                <p class="label-field">{{$company->nature_of_business}}</p>
            
                                </div>
                            </div>
                            </div>
                  </div>
                  <!-- Address -->
                  <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" >Office Address</label>
                                    <p class="label-field">{{$company->office_address}}</p>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">Company Email address</label>
                                    <p class="label-field">{{$company->email_address}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-address">Contact Number</label>
                                    <p class="label-field">{{$company->contact_number}}</p>
                                </div>
                            </div> 
                        
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">About Company</label>
                                        <p class=" label-field">{{$company->about_company}}</p>
                                    </div>
                            </div>

                        </div>

                    </div>

                  <hr class="my-4">
                  <div class="pl-lg-4">
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Facebook</label>
                          <a href="{{$company->facebook}}">
                          <p class="label-field">{{$company->facebook}}</p>
                        </a>
                          <input type="text" id="input-ig" class="form-control text-field" wire:model.defer="company_fb" placeholder="Facebook Link" style="display: none">
                        </div>
                      </div> 
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Instagram</label>
                          <a href="{{$company->instagram}}">
                          <p class="label-field">{{$company->instagram}}</p>
                         </a>
                          <input type="text" id="input-ig" class="form-control text-field" wire:model.defer="company_ig" placeholder="Instagram Link" style="display: none">
                          
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-control-label" for="input-address">Twitter</label>
                          <a href="{{$company->twitter}}">
                          <p class="label-field">{{$company->twitter}}</p>
                          </a>
                          <input id="input-twitter" wire:model.defer="company_twitter" class="form-control text-field" placeholder="Twitter Link" type="text" style="display: none">
                        </div>
                      </div> 
                    </div>
                  </div>
                  <hr class="my-4">
    
                  
              </form>
             </div>
             @endif
            </div>
          </div>
        </div>
      
            
      </div>
</div>
@endif
</div>
