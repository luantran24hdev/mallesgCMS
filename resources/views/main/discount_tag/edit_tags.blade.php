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

      /*  .fit-image{
            width: 100%;
            object-fit: cover;
            height: 180px; !* only if you want fixed height *!
        }*/

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                   <p>Tag Id: <span style="margin-right: 180px;color: red">{{ $tagMaster->tag_id }}</span> | Created On: <span style="margin-right: 180px;color: red">{{ $tagMaster->dated }}</span> | Created By: <span style="color: red">{{ \App\User::getUserName( $tagMaster->user_id)  }}</span> <span style="float: right;color: blue"><a href="{{ route('discount-tags') }}">Back</a></span></p>
                </div>
                <div class="card-body" id="tag-image-body" data-sourceurl="{{route('discount-tags.edit',[$tagMaster->tag_id])}}">
                    <form method="PATCH" action="{{route('discount-tags.update',[$tagMaster->tag_id])}}" id="editDiscountTag">
                    <div class="row" id="tag-image-content">

                            <div class="col-md-3">

                                @if($tagMaster->image)
                                    <div class="col-md-12 mb-3 pr-0">
                                        <img class="card-img-top fit-image" src="{{ $live_url.$tagMaster->image}}" alt="image count">
                                        <a  href="javascript:;" data-href="{{route('tag.deleteimage',['id'=>$tagMaster->tag_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$tagMaster->tag_id}}">
                                            <span class="text-danger">{{__('Delete')}}</span>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-md-12 mb-3 pr-0">
                                        <div class="upload-msg " style="height: 180px; width: 100%" onclick="$('#upload_5').trigger('click');">
                                            <div style="display: table-cell; vertical-align: middle;">Drop Files Here or click upload a photo </div>
                                        </div>
                                    </div>
                                @endif


                                <input type="file" id="upload_5" data-count="5" class="imguploader" value="Drop Files Here to click upload a photo" accept="image/*" style="display: none;" >

                            </div>


                            <div class="col-md-3">
                                <input type="text" name="tag_name" placeholder="Enter Tag" id="tag_name"
                                       class="form-control" required="" list="datalist1" data-autocompleturl="{{route('tag.search')}}" value="{{ $tagMaster->tag_name }}">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                                </div>
                            </div>


                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

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


        $( "#tag_name" ).autocomplete({
            source: function (request, response) {
                $.getJSON($("#tag_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                });
            },
            select: function(event, ui) {
                $("#tag_name").val(ui.item.label);
                $("#tag_id").val(ui.item.value);
               // window.location.href = '{{route("malls")}}/'+ui.item.value;
                return false;
            }
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
                    // Split the base64 string in data and contentType
                    var block = ImageURL.split(";");
                    // Get the content type

                    var contentType = block[0].split(":")[1];// In this case "image/gif"
                    // get the real base64 content of the file
                    var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."

                    // Convert to blob
                    var blob = b64toBlob(realData, contentType);
                    var image_count = $('#selected_image').val();
                    var fd = new FormData();
                    fd.append("image", blob);
                    fd.append("tag_id", "{{@$tagMaster->tag_id}}");

                    // console.log(fd);
                    $.ajax({
                        url: "{{route('tag.uploadimage')}}",
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
                                $('#tag-image-body #tag-image-content').remove();
                                $("#tag-image-body").load( $('#tag-image-body').attr('data-sourceurl') +" #tag-image-content");

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
                            //var image_count = $(this).attr('data-id')

                            $('#tag-image-body #tag-image-content').remove();
                            $("#tag-image-body").load( $('#tag-image-body').attr('data-sourceurl') +" #tag-image-content");
                            toastr.success(data.message);
                        }
                    }
                });

            });
        });


    </script>
@endsection