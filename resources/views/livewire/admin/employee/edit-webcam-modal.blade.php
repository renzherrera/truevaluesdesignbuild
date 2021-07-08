
    <style>
        .modal-backdrop {
            /* bug fix - no overlay */    
            display: none;    
        }
        .modal {
            top:20%;

        }
    </style>
{{-- CAMERA MODAL  --}}
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="webcam_modal" aria-hidden="true" id="editWebcam">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="update_offCam()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-auto">
                <div id="update-webcam-div"></div>
            </div>
            <div class="modal-footer" style="margin-top: -15px;">
                <button id="update-retake_btn" type="button" class="btn btn-secondary" onclick="update_cameraUnfreeze()">Retake</button>
                <button id="update-capture_btn" type="button" class="btn btn-warning" onclick="update_preview_snapshot()">Capture</button>
                <button  id="update-save_btn" type="button" class="btn btn-primary"   onclick="update_saveSnapshot()" data-dismiss="modal" onclick="update_offCam()" >Save changes</button>
       
                <input type="hidden" name="captured_image" id="update-input_webcam" class="update-image-tag" wire:model.defer="updated_captured_image">
            </div>
        </div>
    </div>
</div>


<script src="{{asset('assets/scripts/webcamjs-master/webcam.min.js')}}"></script>
<script >
 function update_configure(){

        Webcam.set({
        width: 280,
        height: 210,
        crop_width:210,
        crop_height:210,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach( '#update-webcam-div' );
    document.getElementById('update-capture_btn').style.display = '';
    document.getElementById('update-save_btn').style.display = 'none';
    document.getElementById('update-retake_btn').style.display = 'none';
} 

    function update_offCam()
    {
        Webcam.reset();

    }
    function update_preview_snapshot() {
       // freeze camera so user can preview pic
       Webcam.freeze();
            
            // swap button sets
            document.getElementById('update-capture_btn').style.display = 'none';
            document.getElementById('update-save_btn').style.display = '';
            document.getElementById('update-retake_btn').style.display = '';
    }
    function update_saveSnapshot() {
    // take snapshot and get image data
    Webcam.snap( function(data_uri) {
    // display results in input webcam
    $(".update-image-tag").val(data_uri);
    document.getElementById('update-profileCamera').innerHTML = 
                            
    '<img id="imageprev" class="" src="'+data_uri+'" style=" display:block; text-align:center; position: absolute; top: 50%; transform: translateY(-50%);margin: auto;width: 130px;  z-index: 999999;"/>  ';
    //update databind livewire below
    var element = document.getElementById('update-input_webcam');
    element.dispatchEvent(new Event('input'));
    } );
    Webcam.reset();
    document.getElementById('reset').style.display = '';
   
    }
    
    function update_cameraUnfreeze() {
        Webcam.unfreeze()
        document.getElementById('update-capture_btn').style.display = '';
        document.getElementById('update-save_btn').style.display = 'none';
        document.getElementById('update-retake_btn').style.display = 'none';

    }
</script>