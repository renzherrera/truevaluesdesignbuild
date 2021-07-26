    

            <style>
                .modal-backdrop {
                    /* bug fix - no overlay */    
                    display: none;    
                }
                .modal {
                    top:20%;
        
                }
            </style>
            <div class="modal fade bd-example-modal-sm" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning mt-2 mb-2 fade show" role="alert">
                                <h4 class="alert-heading">Reminder!</h4>
                                <p class="mb-0 ">Before you import, be sure to change the date format on your excel sheet #4 (Exception Statistic Report). <br> <br> 
                                    Click <a href="{{asset('assets/howToChangeDateFormat.pdf')}}" download>here</a> to download tutorial pdf <small>(How to change date format)</small> .</p>
                                <br>
                                
                            </div>
                            <hr>
                           
                            <div class="form-group">
                                <label for="importExcelFile">Import Excel / CSV File</label><br>
                                <label for="importExcelFile" class="btn btn-outline-alternate">Browse Files</label><br>
                                <p> {{$importExcelFile}}</p>
                                <input hidden type="file" name="importExcelFile" id="importExcelFile" wire:model.defer="importExcelFile" accept=".xlsx, .xls, .csv" required> <br>
                                @error('importExcelFile') <span class="text-danger">You have to browse/choose a valid file.</span> @enderror
                                
                            </div>
                  
        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <div wire:loading.remove>
                            <button type="button" class="btn btn-alternate" wire:click.prevent="import()" >Import to Database</button>

                            </div>
                        </div>
                    </div>
            </div>
        </div>