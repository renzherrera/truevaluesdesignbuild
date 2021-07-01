@extends('layouts.master')
<title>New Employee | True Values Design and Build</title>

@section('content')
@livewire('admin.new-employees')


@endsection

{{-- CAMERA MODAL  --}}
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="webcam_modal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Camera</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="offCam()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-auto">
                <div id="webcam-div"></div>
            </div>
            <div class="modal-footer" style="margin-top: -15px;">
                <button id="retake_btn" type="button" class="btn btn-secondary" onclick="cameraUnfreeze()">Retake</button>
                <button id="capture_btn" type="button" class="btn btn-warning" onclick="preview_snapshot()">Capture</button>
                <button id="save_btn" type="button" class="btn btn-primary"  onclick="saveSnapshot()" data-dismiss="modal" onclick="offCam()">Save changes</button>
       
                <input type="hidden" name="captured_image" id="input_webcam" class="image-tag" wire:model.defer="captured_image">
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="{{asset('assets/scripts/webcamjs-master/webcam.js')}}"></script>
<script language="JavaScript">
 function configure(){

        Webcam.set({
        width: 280,
        height: 210,
        crop_width:210,
        crop_height:210,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach( '#webcam-div' );
    document.getElementById('capture_btn').style.display = '';
    document.getElementById('save_btn').style.display = 'none';
    document.getElementById('retake_btn').style.display = 'none';
} 

    function offCam()
    {
        Webcam.reset();

    }
    function preview_snapshot() {
   	// freeze camera so user can preview pic
       Webcam.freeze();
			
			// swap button sets
			document.getElementById('capture_btn').style.display = 'none';
			document.getElementById('save_btn').style.display = '';
			document.getElementById('retake_btn').style.display = '';
    }
    function saveSnapshot() {
    // take snapshot and get image data
    Webcam.snap( function(data_uri) {
    // display results in page
    // $(".image-tag").val(data_uri);
    document.getElementById('profileCamera').innerHTML = 
    '<img id="imageprev" class="" src="'+data_uri+'" style="height: 130px; width: 130px; background-color: #cfcfcf; border-radius:5%; "/>  ';
    //update databind livewire below
    // var element = document.getElementById('input_webcam');
    // element.dispatchEvent(new Event('input'));
    } );
    Webcam.reset();


    }
    
    function cameraUnfreeze() {
        Webcam.unfreeze()
        document.getElementById('capture_btn').style.display = '';
        document.getElementById('save_btn').style.display = 'none';
        document.getElementById('retake_btn').style.display = 'none';

    }
</script>