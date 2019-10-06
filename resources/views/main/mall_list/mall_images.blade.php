
@extends('layouts.app')
@section('style')

    <style>
        .card{
            margin-bottom: 0px;
        }
        .btn-default{
            color: #fff;
            background-color: #ccc;
            border-color: #ccc;
        }
        .active{
            background-color: #007bff !important;
        }
        .pic {
            width: 100%;
            height: 100%;
        }


        .upload-demo-wrap {
            width: 100%;
            height: 100%;
        }

        .upload-msg {
            text-align: center;
            font-size: 22px;
            color: #aaa;
            border: 1px solid #aaa;
            display: table;
            cursor: pointer;
        }

        .fit-image{
            width: 100%;
            object-fit: cover;
            height: 320px; /* only if you want fixed height */
        }

    </style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                {{ $mall->mall_name }}
                <span class="link_color" style="float: right">
                    Back
                </span>
            </div>

            <div class="card-header-malle" style="background: white">
              Images For Website
            </div>


            <div class="card-body" id="promo-image-body" data-sourceurl="{{route('malls.images',['mall__id'=>$mall->mall_id])}}">

                <div class="row" id="promo-image-content">
                    <input type="text" id="selected_image" style="display: none;">

                         @if($mall->web_image)
                             <div class="col-md-12 mb-3 pr-0">
                                 <img class="card-img-top fit-image" src="{{ $live_url.$mall->web_image}}" alt="image count">
                                 <a  href="javascript:;" data-href="{{route('malls.webdeleteimage',['id'=>$mall->mall_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$mall->mall_id}}">
                                     <span class="text-danger">{{__('Delete')}}</span>
                                 </a>
                             </div>
                         @else
                            <div class="col-md-12 mb-3 pr-0">
                                <div class="upload-msg " style="height: 320px; width: 100%" onclick="$('#upload_1').trigger('click');">
                                    <div style="display: table-cell; vertical-align: middle;">Drop Files Here or click upload a photo </div>
                                </div>
                            </div>
                         @endif


                        <input type="file" id="upload_1" data-count="1" class="imguploader" value="Drop Files Here to click upload a photo" accept="image/*" style="display: none;" >



                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                Images for App
            </div>
            <div class="card-body" id="promo-image-body1" data-sourceurl="">

                <div class="row" id="promo-image-content1">
                    <input type="text" id="selected_image" style="display: none;">
                    @for($i=1;$i<4;$i++)
                        @php
                            $empty = true;
                        @endphp

                           {{--     <div class="col-md-4 mb-3 pr-0">
                                    <img class="card-img-top fit-image" src="" alt="image count">
                                    <a  href="javascript:;" data-href="" data-method="POST" class="btn-pi-delete" data-id="">
                                        <span class="text-danger">{{__('Delete')}}</span>
                                    </a>
                                </div>--}}

                            <div class="col-md-4 mb-3 pr-0"> 
                                <div class="upload-msg " style="height: 213px; max-width: 310px; width: 100%" >
                                   {{-- <div style="display: table-cell; vertical-align: middle;">Click to upload a file </div>--}}
                                </div>
                            </div>

                        <input type="file" id="upload_{{$i}}" data-count="{{$i}}" class="imguploader" value="Choose a file" accept="image/*" style="display: none;" >
                    @endfor

                    
 
                </div>

             </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletepromotionmodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalpromotionlabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletemodalpromotionlabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <p class="font-12">{{__('Are you sure you want to delete Item?')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('No')}}</button>
                <button type="button" class="btn btn-danger" id="btnDeletePromotion">{{__('Yes')}}</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="croppermodal" tabindex="-1" role="dialog" aria-labelledby="cropmodallabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropmodallabel">Image Cropper</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="upload-demo-wrap" style="display: none">
                    <div id="upload-demo"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                <button type="button" class="btn upload-result">{{__('Upload')}}</button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')

<link rel="stylesheet" type="text/css" href="{{asset('css/croppie.css')}}">
<script type="text/javascript" src="{{asset('js/croppie.min.js')}}"></script>
<script>


    $( function() {
        var $uploadCrop = $('#upload-demo');
        $uploadCrop.croppie({
            enableResize: true,
            enableExif: true,
            viewport: {
                width: 550,
                height: 390,
            },
            boundary: {
                width: 647,
                height: 459
            }
        });

        $('#croppermodal').on('shown.bs.modal', function() {
            $uploadCrop.croppie('bind');
        });



        $(document).on('click','.upload-result', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {

            var ImageURL = resp;

            //console.log(ImageURL);
            // Split the base64 string in data and contentType
            var block = ImageURL.split(";");
            // Get the content type

           // console.log(block);
            var contentType = block[0].split(":")[1];// In this case "image/gif"
            // get the real base64 content of the file
            var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."

            // Convert to blob
            var blob = b64toBlob(realData, contentType);

            // Create a FormData and append the file
            var fd = new FormData();
            fd.append("image", blob);
            fd.append("mall_id", "{{@$mall->mall_id}}");
            //console.log('dddddddddddd');

           // console.log(fd);
            $.ajax({
                url: "{{route('malls.uploadimage')}}",
                data: fd,// the formData function is available in almost all new browsers.
                type:"POST",
                contentType:false,
                processData:false,
                cache:false,
                dataType:"json", // Cha
                success:function(data){
                    if(data.status==='error'){
                        errorReturn(data)
                    }else{
                        $('#promo-image-body #promo-image-content').remove();
                        $("#promo-image-body").load( $('#promo-image-body').attr('data-sourceurl') +" #promo-image-content");
                        $('#croppermodal').modal('hide');
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    exeptionReturn(data);
                }
            });

        });
        });



        $(document).on('change', '.imguploader', function () {
            readFile(this);
            $('#selected_image').val($(this).attr('data-count'));
        });

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                $('#croppermodal').modal('show');

                reader.onload = function (e) {
                    $('.upload-demo-wrap').show();
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });

                }

                reader.readAsDataURL(input.files[0]);

            }
            else {
                alert("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        function b64toBlob(b64Data, contentType, sliceSize) {
            contentType = contentType || '';
            sliceSize = sliceSize || 512;

            var byteCharacters = atob(b64Data);
            var byteArrays = [];

            for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                var slice = byteCharacters.slice(offset, offset + sliceSize);

                var byteNumbers = new Array(slice.length);
                for (var i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                var byteArray = new Uint8Array(byteNumbers);

                byteArrays.push(byteArray);
            }

            var blob = new Blob(byteArrays, {type: contentType});
            return blob;
        }
    });



    $(document).on('click', '.btn-pi-delete', function(e){
        e.preventDefault();
        var btndelete = $(this);

        $('#deletepromotionmodal').modal('show');

        $('#btnDeletePromotion').unbind().click(function(){

                $.ajax({
                    url: btndelete.attr('data-href'),
                    type: btndelete.attr('data-method'),
                    dataType:'json',
                    success:function(data){
                        if(data.status==='error'){
                            errorReturn(data)
                        }else{
                            $('#deletepromotionmodal').modal('hide');
                            $('#promo-image-body #promo-image-content').remove();
                            $("#promo-image-body").load( $('#promo-image-body').attr('data-sourceurl') +" #promo-image-content");
                            toastr.success(data.message);
                        }
                    }
                });

        });
    });



    </script>


@endsection
 