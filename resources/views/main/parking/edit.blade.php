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
                    {{ $mall->mall_name  }} Parking Info

                    <a href="{{route('malls')}}">
                    <span class="link_color" style="float: right">
                        Back
                    </span>
                    </a>
                </div>

                <div class="card-body" id="tag-image-body"
                     data-sourceurl="{{route('mall-parking.edit',[$mall->mall_id])}}">
                    <form method="PUT" action="{{route('mall-parking.update',[$mall->mall_id])}}"
                          id="editDiscountTag">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-around">

                                <div class="form-group mx-1">
                                    <label class="mb-2 font-12">Car lots</label>
                                    <input class="form-control w-100" type="number" name="lots_cars"
                                           value="{{ $parking->lots_cars?? 0}}"/>
                                </div>


                                <div class="form-group mx-1">
                                    <label class="mb-2 font-12">Bike lots</label>
                                    <input class="form-control w-100" type="number" name="lots_bike"
                                           value="{{ $parking->lots_bike?? 0}}"/>
                                </div>


                                <div class="form-group mx-1">
                                    <label class="mb-2 font-12">Handicap</label>
                                    <input class="form-control w-100" type="number" name="lots_handicap"
                                           value="{{ $parking->lots_handicap?? 0}}"/>
                                </div>


                                <div class="form-group mx-1">
                                    <label class="mb-2 font-12">EV lots</label>
                                    <input class="form-control w-100" type="number" name="lots_ev"
                                           value="{{ $parking->lots_ev?? 0}}"/>
                                </div>

                                <div class="form-group mx-1">
                                    <label class="mb-2 font-12">Family lots</label>
                                    <input class="form-control w-100" type="number" name="lots_family"
                                           value="{{ $parking->lots_family?? 0}}"/>
                                </div>


                                <div class="form-group mx-1">
                                    <label class="mb-2 font-12">Views</label>
                                    <input class="form-control w-100" type="number" name="views"
                                           value="{{ $parking->views?? 0}}"/>
                                </div>


                                <div class="form-group mx-1">
                                    <label class="mb-2 font-12">Featured</label>
                                    <select name="featured" id="" class="dd-orange">
                                        <option value="N"
                                                @if(!isset($parking->featured) || $parking->featured!='Y') selected @endif>
                                            No
                                        </option>
                                        <option value="Y"
                                                @if(isset($parking->featured) && $parking->featured=='Y') selected @endif>
                                            Yes
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group ml-md-5 ml-2">
                                    <button type="submit" class="btn btn-primary mt-4 float-right" id="btnEditPromo">
                                        {{$parking? 'Update': 'Save'}}
                                    </button>
                                </div>
                            </div>
                            {{--                            <div class="col-md-1 col-6">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label class="mb-2 font-12">Car lots</label>--}}
                            {{--                                    <input class="form-control w-100" type="number" name="lots_cars"--}}
                            {{--                                           value="{{ $parking->lots_cars?? 0}}"/>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            {{--                            <div class="col-md-1 col-6">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label class="mb-2 font-12">Bike lots</label>--}}
                            {{--                                    <input class="form-control w-100" type="number" name="lots_bike"--}}
                            {{--                                           value="{{ $parking->lots_bike?? 0}}"/>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            {{--                            <div class="col-md-1 col-6">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label class="mb-2 font-12">Handicap</label>--}}
                            {{--                                    <input class="form-control w-100" type="number" name="lots_handicap"--}}
                            {{--                                           value="{{ $parking->lots_handicap?? 0}}"/>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            {{--                            <div class="col-md-1 col-6">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label class="mb-2 font-12">EV lots</label>--}}
                            {{--                                    <input class="form-control w-100" type="number" name="lots_ev"--}}
                            {{--                                           value="{{ $parking->lots_ev?? 0}}"/>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            {{--                            <div class="col-md-2 col-6">--}}
                            {{--                                <div class="form-group w-75">--}}
                            {{--                                    <label class="mb-2 font-12">Family lots</label>--}}
                            {{--                                    <input class="form-control w-100" type="number" name="lots_family"--}}
                            {{--                                           value="{{ $parking->lots_family?? 0}}"/>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            {{--                            <div class="col-md-1 col-6">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label class="mb-2 font-12">Views</label>--}}
                            {{--                                    <input class="form-control w-100" type="number" name="views"--}}
                            {{--                                           value="{{ $parking->views?? 0}}"/>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            {{--                            <div class="col-md-1 col-6">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label class="mb-2 font-12">Featured</label>--}}
                            {{--                                    <select name="mall_active" id="" class="dd-orange">--}}
                            {{--                                        <option value="N"--}}
                            {{--                                                @if(!isset($parking->mall_active) || $parking->mall_active!='Y') selected @endif>--}}
                            {{--                                            No--}}
                            {{--                                        </option>--}}
                            {{--                                        <option value="Y"--}}
                            {{--                                                @if(isset($parking->mall_active) && $parking->mall_active=='Y') selected @endif>--}}
                            {{--                                            Yes--}}
                            {{--                                        </option>--}}
                            {{--                                    </select>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            {{--                            <div class="col col-md-2">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <button type="submit" class="btn btn-primary mt-4 float-right" id="btnEditPromo">--}}
                            {{--                                        {{$parking? 'Update': 'Save'}}--}}
                            {{--                                    </button>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mb-2 font-12">Car Park Charges</label>
                                    <textarea type="text"
                                              name="car_charges"
                                              class="form-control"
                                              rows="15">{{$parking->car_charges ?? null }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mb-2 font-12">Bike Charges</label>
                                    <textarea type="text"
                                              name="bike_charges"
                                              class="form-control"
                                              rows="7">{{$parking->bike_charges ?? null }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="mb-2 font-12">Free Parking</label>
                                    <textarea type="text"
                                              name="free_parking"
                                              class="form-control"
                                              rows="6">{{$parking->free_parking ?? null }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label class="mb-2 font-12">Operating Hours</label>
                                        <div>
                                            <input type="checkbox" name="24_hours"
                                                   @if(isset($parking['24_hours']) && $parking['24_hours'] == "Y") checked @endif>
                                            <label class="mb-2 font-12">24 Hours</label>
                                        </div>
                                    </div>
                                    <textarea type="text"
                                              name="operating_hours"
                                              class="form-control"
                                              rows="4">{{$parking->operating_hours ?? null }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Grace Period')}}</label>
                                    <div class="input-group mb-3">
                                        <input type="text"
                                               value="{{$parking->grace_period?? null}}"
                                               required
                                               name="grace_period"
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mb-2 font-12">Car Parking Info</label>
                                    <textarea type="text"
                                              name="car_park_info"
                                              class="form-control"
                                              rows="5">{{$parking->car_park_info ?? null }}</textarea>

                                </div>
                            </div>


                            {{--                            <div class="col-md-6">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label class="mb-2 font-12">Paid Parking</label>--}}
                            {{--                                    <span style="float: right"><input type="checkbox" name="no_parking_info" value="Y" @if(isset($parkiing_info == "Y") checked @endif><label class="mb-2 font-12">No Parking Info</label></span>--}}
                            {{--                                    <textarea style="height: 300px;" type="text" name="paid_parking" id="description" class="form-contr</textarea>--}}

                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            {{--                            <div class="col-md-4" >--}}
                            {{--                                <div class="col-md-12">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label class="mb-2 font-12">Free Parking</label>--}}
                            {{--                            <textarea style="height: 100px;" type="text" name="free_parking" id="location" class="form-con</textarea>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-12">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label class="mb-2 font-12">{{__('Grace Period')}}</label>--}}
                            {{--                                        <div class="input-group mb-3">--}}
                            {{--                                            <input type="text" value="{{$parking->grace_period?? ''}}" required="" name="grace_period" class="form-control">--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-12 row">--}}
                            {{--                                    <div class="col-md-6">--}}
                            {{--                                        <div class="form-group">--}}
                            {{--                                            <label class="mb-2 font-12">{{__('Parking Spaces')}}</label>--}}
                            {{--                                            <div class="input-group mb-3">--}}
                            {{--                                                <input type="text" value="{{$parking->total_parking?? ''}}" class="form-control" name="total_parking">--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-md-6">--}}
                            {{--                                        <div class="form-group">--}}
                            {{--                                            <label class="mb-2 font-12">{{__('Available Now')}}</label>--}}
                            {{--                                            <div class="input-group mb-3">--}}
                            {{--                                                <input type="text" value="{{$parking->available_parking?? ''}}" class="form-control" name="available_parking">--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            {{--                            </div>--}}

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">

                <div class="card-header-malle">
                    Services in Carpark
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
                                   data-sourceurl="{{ route('mall-parking.edit', $mall->mall_id) }}">
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

    @include('main.parking.parking_images')

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
                    fd.append("mall_id", "{{@$parking->mall_id}}");
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
            {{--data+='&mall_id='+ {{$mall->mall_id}};--}}

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
                // window.location.href = '{{route("malls")}}/'+ui.item.value;
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
