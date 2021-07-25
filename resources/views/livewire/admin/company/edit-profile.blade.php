<title>Edit - Company Profile | True Value Design & Build</title>
<style>
    p {
        font-weight: bold;
    }
    h6 {
        text-transform: uppercase;
    }
</style>

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
                        <a type="button" href="{{route('admin.company-profile')}}" id="cancel-profile" class="btn btn-sm btn-warning  text-right flex flex-end" >Cancel</a>
                        <a id="save-profile" wire:click.prevent="update()" class="btn btn-sm btn-info  text-right flex flex-end text-white">Apply Changes</a>
                      </div>
                  </div>
                    
              </div>
              <div class="card-body">
                  <input type="hidden" name="_token" value="y9L7xhY1D2wocvzx8Ed2QWL3Y7lnpRY3eAJU2WOG">             
                  <input type="hidden" wire.model.defer="company_id">
                  <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="updated_image">Company Logo</label>
                            </div>
                          </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">

                                @if ($updated_image)
                                <img class="image-field" width="250px;" style="border-radius:5%; " src="{{$updated_image->temporaryUrl()}}"  alt="">
                                 <button id="reset" class="mb-2 mr-2 mt-1 btn-icon btn-icon-only btn-pill btn btn-light position-absolute" wire:click="resetImage()" style="z-index: 999999999999; "><i class="pe-7s-refresh btn-icon-wrapper"> </i></button>
                                @elseif($image)
                                <img class="image-field" width="250px;" style="border-radius:5%; " src="{{asset('storage/images/'.$image)}}" alt="">
                                <button id="null" wire:click="imageNull()" class="mb-2 mr-2 ml-3 mt-1 btn-icon btn-icon-only btn-pill btn btn-light position-absolute" style="z-index: 9999999999999999; "><i class="pe-7s-trash btn-icon-wrapper"> </i></button>
                                @endif





                            </div>
                        <label type="button" for="updated_image" class="btn btn-sm btn-secondary mb-2 text-right flex flex-end">Browse Image</label>
                            <input type="file" id="updated_image" wire:model.defer="updated_image" hidden>
                          </div>

                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">Company Name</label>
    
                          <input type="text" class="form-control text-field" wire:model.defer="company_name" placeholder="Company Name" >
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">Nature of Business</label>
    
                          <input type="text" id="input-nature" class="form-control text-field" wire:model.defer="nature_of_business" placeholder="Business Scope">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Address -->
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-address">Office Address</label>
                          <input id="input-address" class="form-control text-field" wire:model.defer="office_address" placeholder="Office Address"  type="text" >
                        </div>
                      </div> 
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Company Email address</label>
                          <input type="email" id="input-email" wire:model.defer="email_address" class="form-control text-field" placeholder="Email address" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-address">Contact Number</label>
                          <input id="input-contact" class="form-control text-field" wire:model.defer="contact_number" placeholder="Mobile/Tel no." type="text" >
                        </div>
                      </div> 
                   
                   </div>
                  <div class="row">
                      <div class="col-md-12">

                            <div class="form-group">
                                <label class="form-control-label" for="input-address">About Company</label>
                                <textarea rows="2" class="form-control text-field" wire:model.defer="about_company" placeholder="A few words about the company ..." ></textarea>
                            </div>
                     </div>

                  </div>
                    </div>
                  <hr class="my-4">
                  
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Facebook</label>
                       
                          <input type="text" id="input-fb" class="form-control text-field" wire:model.defer="facebook" placeholder="Facebook Link" >
                        </div>
                      </div> 
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Instagram</label>
                        
                          <input type="text" id="input-ig" class="form-control text-field" wire:model.defer="instagram" placeholder="Instagram Link" >
                          
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-control-label" for="input-address">Twitter</label>
                          
                          <input id="input-twitter" wire:model.defer="twitter" class="form-control text-field" placeholder="Twitter Link" type="text" >
                        </div>
                      </div> 
                    </div>
                  </div>
    
                  
            </div>
            </div>
          </div>
        </div>
      
            
      </div>
</div>