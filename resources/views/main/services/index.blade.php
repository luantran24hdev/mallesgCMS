@extends('layouts.app')
@section('style')

    <style>
        .card {
            margin-bottom: 0px;
        }

        .card-body .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
            padding: 0 0.5vw;
        }

        .dd-orange {
            padding: .375rem .75rem
        }

        .btn-default {
            color: #fff;
            background-color: #ccc;
            border-color: #ccc;
        }

        .active {
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
                    Service Type

                    <a href="{{ url()->previous() }}">
                    <span class="link_color" style="float: right">
                        Back
                    </span>
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('service.store')}}" id="addParkingService">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="service_name" placeholder="Search for service" id="service_name"
                                       class="form-control" required="" list="datalist1" data-autocompleturl="{{route('service.search')}}">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div class="row">
                        <div class="col-12">
                            Service Name
                        </div>
                        <div class="col-12">
                            <table class="table table-striped"
                                   id="parking-service-table"
                                   data-sourceurl="{{ route('service.index') }}">
                                <thead>
                                <th></th>
                                <th>service name</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($services as $service)
                                    <tr class="row-location" data-id="{{@$service->service_id}}">
                                        <td>
                                            @if(!empty($service->service_image))
                                                <img src="{{$image_url.'stock/'.$service->service_image}}" width="50px" height="50px">
                                            @else
                                                <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>
                                            @endif
                                        </td>
                                        <td>
                                            {{$service->service_name}}
                                        </td>
                                        <td>
                                            <a href="{{route('service.edit',[$service->service_id])}}"><span class="text-info">Edit</span></a>
                                            |
                                            <a href="javascript:;"
                                               data-href="{{route('service.destroy',[$service->service_id])}}"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="{{$service->service_id}}">
                                                <span class="text-danger">Delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('partials.delete_model')

    @include('partials.image_model')
@endsection


@section('script')
    <link rel="stylesheet" type="text/css" href="{{asset('css/croppie.css')}}">
    <script type="text/javascript" src="{{asset('js/croppie.min.js')}}"></script>
    <script>


        $(document).on('submit', '#editDiscountTag', function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');
            var type = $(this).attr('method');

            $.ajax({
                url: url,
                type: type,
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.status === 'error') {
                        toastr.error(data.message, 'Error');
                    } else {
                        //$("#discount-tag-table").load( $('#discount-tag-table').attr('data-sourceurl') +" #discount-tag-table");
                        toastr.success(data.message);
                    }
                },
                error: function (data) {
                    exeptionReturn(data);
                }
            });
        });


        $(function () {
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

            $('#croppermodal').on('shown.bs.modal', function () {
                $uploadCrop.croppie('bind');
            });


            $(document).on('click', '.upload-result', function (ev) {
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
{{--                    fd.append("mall_id", "{{@$parking->mall_id}}");--}}
                    fd.append("image_count", image_count);


                    //console.log('dddddddddddd');

                    // console.log(fd);
                    $.ajax({
                        url: "{{route('parking.uploadimage')}}",
                        data: fd,// the formData function is available in almost all new browsers.
                        type: "POST",
                        contentType: false,
                        processData: false,
                        cache: false,
                        dataType: "json", // Cha
                        success: function (data) {
                            if (data.status === 'error') {
                                errorReturn(data)
                            } else {
                                $('#croppermodal').modal('hide');
                                toastr.success(data.message);
                                window.setTimeout(function () {
                                    location.reload()
                                }, 2000)
                            }
                        },
                        error: function (data) {
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
                        }).then(function () {
                            console.log('jQuery bind complete');
                        });

                    }

                    reader.readAsDataURL(input.files[0]);

                } else {
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


        $(document).on('click', '.btn-pi-delete', function (e) {
            e.preventDefault();
            var btndelete = $(this);

            $('#deletepromotionmodal').modal('show');

            $('#btnDeletePromotion').unbind().click(function () {

                $.ajax({
                    url: btndelete.attr('data-href'),
                    type: btndelete.attr('data-method'),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 'error') {
                            errorReturn(data)
                        } else {
                            $('#deletepromotionmodal').modal('hide');
                            //var image_count = $(this).attr('data-id');
                            toastr.success(data.message);
                            window.setTimeout(function () {
                                location.reload()
                            }, 2000)
                        }
                    }
                });

            });
        });


    </script>

    <script>

        $(document).on('submit','#addParkingService', function(e){
            e.preventDefault();
            var data = $(this).serialize();
            let url = $(this).attr('action');
            let type =  $(this).attr('method');

            $.ajax({
                url: url,
                type: type,
                dataType:'json',
                data:data,
                success:function(data){
                    if(data.status==='error'){
                        toastr.error(data.message, 'Error');
                    }else{
                        $("#parking-service-table").load( $('#parking-service-table').attr('data-sourceurl') +" #parking-service-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    exeptionReturn(data);
                }
            });
        });

        // delete
        $(document).on('click', '.btn-delete', function(e){
            e.preventDefault();
            var btndelete = $(this);

            $('#deletelocationmodal').modal('show');

            $('#btnDeleteLocation').unbind().click(function(){

                $.ajax({
                    url: btndelete.attr('data-href'),
                    type: btndelete.attr('data-method'),
                    dataType:'json',
                    success:function(data){
                        if(data.status==='error'){
                            toastr.error(data.message);
                        }else{
                            $('#deletelocationmodal').modal('hide');
                            $('.row-location[data-id="'+btndelete.attr('data-id')+'"]').remove();

                            toastr.success(data.message);

                        }
                    }
                });

            });
        });

        $( "#service_name" ).autocomplete({
            source: function (request, response) {
                $.getJSON($("#service_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                });
            },
            select: function(event, ui) {
                $("#service_name").val(ui.item.label);
                $("#service_id").val(ui.item.value);
                return false;
            }
        });


        // $(document).on('change', '.tag_column_update', function(e){
        //     e.preventDefault();
        //     //debugger;
        //     var selectOp = $(this);
        //     var attrName = selectOp.attr("name");
        //
        //     $.ajax({
        //         url: selectOp.attr('data-href'),
        //         type: selectOp.attr('data-method'),
        //         dataType:'json',
        //         data: {
        //             name : selectOp.attr('name'),
        //             value : selectOp.find('option:selected').val()
        //         },
        //         success:function(data){
        //             console.log(data);
        //             if(data.status==='error'){
        //                 errorReturn(data)
        //             }else{
        //                 //$('#merchant-list-table tbody').remove();
        //                 //  $("#merchant-list-table").load( $('#merchant-list-table').attr('data-sourceurl') +" #merchant-list-table");
        //                 toastr.success(data.message);
        //             }
        //         },
        //         error: function(data){
        //             console.log(data);
        //             exeptionReturn(data);
        //         }
        //     });
        //
        // });

    </script>
@endsection
