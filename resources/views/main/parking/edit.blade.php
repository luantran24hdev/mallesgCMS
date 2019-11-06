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



    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">

                <div class="card-header-malle">
                    {{ @$parking->mall_name  }} Parking Info

                    <a href="{{route('malls')}}">
                    <span class="link_color" style="float: right">
                        Back
                    </span>
                    </a>
                </div>

                <div class="card-body" id="tag-image-body" data-sourceurl="{{route('mall-parking.edit',[$parking->mall_id])}}">
                    <form method="PATCH" action="{{route('mall-parking.update',[$parking->mall_id])}}" id="editDiscountTag">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-2 font-12">Paid Parking</label>
                                    <span style="float: right"><input type="checkbox" name="no_parking_info" value="Y" @if($parking->no_parking_info == "Y") checked @endif><label class="mb-2 font-12">No Parking Info</label></span>
                                    <textarea style="height: 300px;" type="text" name="paid_parking" id="description" value="{{$parking->paid_parking}}" class="form-control">{{$parking->paid_parking}}</textarea>

                                </div>
                            </div>

                            <div class="col-md-4" >
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Free Parking</label>
                                        <textarea style="height: 100px;" type="text" name="free_parking" id="location" class="form-control" value="{{$parking->free_parking}}">{{$parking->free_parking}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">{{__('Grace Period')}}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" value="{{$parking->grace_period}}" required="" name="grace_period" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">{{__('Parking Spaces')}}</label>
                                            <div class="input-group mb-3">
                                                <input type="text" value="{{$parking->total_parking}}" class="form-control" name="total_parking">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">{{__('Available Now')}}</label>
                                            <div class="input-group mb-3">
                                                <input type="text" value="{{$parking->available_parking}}" class="form-control" name="available_parking">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="btnEditPromo">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

     @include('main.parking.parking_images')

    @include('partials.image_model')
@endsection


@section('script')
    <link rel="stylesheet" type="text/css" href="{{asset('css/croppie.css')}}">
    <script type="text/javascript" src="{{asset('js/croppie.min.js')}}"></script>
    <script>


        $(document).on('submit','#editDiscountTag', function(e){
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');
            var type =  $(this).attr('method');

            $.ajax({
                url: url,
                type: type,
                dataType:'json',
                data:data,
                success:function(data){
                    if(data.status==='error'){
                        toastr.error(data.message, 'Error');
                    }else{
                        //$("#discount-tag-table").load( $('#discount-tag-table').attr('data-sourceurl') +" #discount-tag-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    exeptionReturn(data);
                }
            });
        });





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
                    var image_count = $('#selected_image').val();
                    // Create a FormData and append the file
                    var fd = new FormData();
                    fd.append("image", blob);
                    fd.append("mall_id", "{{@$parking->mall_id}}");
                    fd.append("image_count", image_count);


                    //console.log('dddddddddddd');

                    // console.log(fd);
                    $.ajax({
                        url: "{{route('parking.uploadimage')}}",
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
                                $('#croppermodal').modal('hide');
                                toastr.success(data.message);
                                window.setTimeout(function(){location.reload()},2000)
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
                            //var image_count = $(this).attr('data-id');
                            toastr.success(data.message);
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    }
                });

            });
        });



    </script>
@endsection