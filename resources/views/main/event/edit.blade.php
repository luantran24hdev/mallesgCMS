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
                   <p>Event Id: <span style="margin-right: 120px;color: red">{{ $event->event_id }}</span> | Created On: <span style="margin-right: 120px;color: red">{{ $event->created_on }}</span> | Created By: <span style="color: red">{{ \App\User::getUserName( $event->user_id)  }}</span> <span style="float: right;color: blue"><a href="{{ route('mall-events',['id'=>$event->mall_id]) }}">Back</a></span></p>
                </div>
                <div class="card-body" id="tag-image-body" data-sourceurl="{{route('mall-events.edit',[$event->event_id])}}">
                    <form method="PATCH" action="{{route('mall-events.update',[$event->event_id])}}" id="editDiscountTag">
                        <div class="row">
                            <div class="col-md-6">
                                @csrf
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Event Name')}}</label>
                                    <input type="text" name="event_name" id="promo_name" placeholder="Promotion Name" value="{{$event->event_name}}" required="" class="form-control">

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Mall Name')}}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" value="{{$event->mall->mall_name}}" required="" class="form-control" readonly="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Category')}}</label>
                                    <div class="input-group mb-2">
                                            <select id="town_control" class="form-control" name="ec_id">

                                                @if(!empty($events_categorys))
                                                    <option value=""> --- Select ---- </option>
                                                    @foreach($events_categorys as $category)
                                                        <option value="{{ @$category->ec_id }}" @if($event->ec_id == $category->ec_id) selected @endif >{{ @$category->event_cat }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-2 font-12">Description</label>
                                    <textarea style="height: 200px;" type="text" name="event_description" id="description" value="{{$event->event_description}}" class="form-control">{{$event->event_description}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6 row" >
                                <div class="col-md-6">
                                    <label class="mb-2 font-12">Start Date</label>
                                    <div class="input-group">
                                        <input type="text" name="start_date" id="start_date" placeholder="Start Date" class="form-control py-2 border-right-0 border hasDatepicker" value="{{ $event->start_date }}">

                                        <span class="input-group-append">
                                                <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-2 font-12">End Date</label>
                                    <div class="input-group">


                                        <input type="text" name="end_date" id="end_date" placeholder="End Date" class="form-control py-2 border-right-0 border hasDatepicker" value="@if($event->end_date != "") {{ $event->end_date }} @endif" @if($event->end_date == '') disabled @endif>

                                        <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <input type="checkbox" name="no_end_date" id="no_end_date" onclick="noenddate()" @if($event->end_date == null) checked @endif>
                                    No End Date</label>
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-2 font-12">Timing</label>
                                    <div class="input-group">

                                        <input type="text" name="event_timing" placeholder="Timing" value="{{$event->event_timing}}"  class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mb-2 font-12">Event Venue</label>
                                    <textarea style="height: 100px;" type="text" name="location" id="location" class="form-control">{{$event->location}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label class="mb-2 font-12">
                                            <input type="checkbox" value="Y" name="just_1_day" id="" @if($event->just_1_day == 'Y') checked @endif>
                                            Just One Day</label>
                                    </div>
                                    <br>
                                    <div class="checkbox">
                                        <label class="mb-2 font-12">
                                            <input type="checkbox" value="Y" name="all_day" id="" @if($event->all_day == 'Y') checked @endif>
                                            All Day</label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary" id="btnEditPromo">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

     @include('main.event.event_images')

    @include('partials.image_model')
@endsection


@section('script')
    <link rel="stylesheet" type="text/css" href="{{asset('css/croppie.css')}}">
    <script type="text/javascript" src="{{asset('js/croppie.min.js')}}"></script>
    <script>

        $('#start_date,#end_date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
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


        function noenddate(){
            // /  debugger;
            /*$('#no_end_date').click(function() {*/
            if ($('#no_end_date'). prop("checked") == true) {
                $("#end_date").attr('disabled', true).val("");
            }
            else {
                $("#end_date").attr('disabled', false);
            }
            /*});*/
        }


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
                    fd.append("event_id", "{{@$event->event_id}}");
                    fd.append("event_count", image_count);


                    //console.log('dddddddddddd');

                    // console.log(fd);
                    $.ajax({
                        url: "{{route('events.uploadimage')}}",
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