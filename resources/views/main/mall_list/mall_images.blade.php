
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
                <a href="{{route('malls')}}">
                    <span class="link_color" style="float: right">
                        Back
                    </span>
                </a>

            </div>

            <div class="card-header-malle" style="background: white">
              Images For Website
            </div>


            <div class="card-body" id="promo-image-body" data-sourceurl="{{route('malls.images',['mall__id'=>$mall->mall_id])}}">

                <div class="row" id="promo-image-content">
                   {{-- <input type="text" id="selected_image" style="display: none;">--}}

                         @if($mall->web_image)
                             <div class="col-md-12 mb-3 pr-0">
                                 <img class="card-img-top fit-image" src="{{ $live_url.$mall->web_image}}" alt="image count">
                                 <a  href="javascript:;" data-href="{{route('malls.webdeleteimage',['id'=>$mall->mall_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$mall->mall_id}}">
                                     <span class="text-danger">{{__('Delete')}}</span>
                                 </a>
                             </div>
                         @else
                            {{--<div class="col-md-12 mb-3 pr-0">
                                <div class="upload-msg " style="height: 320px; width: 100%" onclick="$('#upload_5').trigger('click');">
                                    <div style="display: table-cell; vertical-align: middle;">Drop Files Here or click upload a photo </div>
                                </div>
                            </div>
--}}
                            <div class="col-md-4">
                                <form action="{{ route('malls.uploadimage') }}" class="dropzone" id="image_5">
                                    @csrf
                                    <input type="hidden" name="mall_id" value="{{ $mall->mall_id }}">
                                </form>
                            </div>
                         @endif


                        {{--<input type="file" id="upload_5" data-count="5" class="imguploader" value="Drop Files Here to click upload a photo" accept="image/*" style="display: none;" >--}}



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
            <div class="card-body" id="promo-image-body1" data-sourceurl="{{route('malls.images',['mall__id'=>$mall->mall_id])}}">

                <div class="row" id="promo-image-content1">
                    <input type="text" id="selected_image" style="display: none;">
                    @for($i=1;$i<4;$i++)
                        @php
                            $empty = true;
                        @endphp

                        @if(!empty($mall->mallImage))
                        @foreach($mall->mallImage as $mall_image)
                            @if($mall_image->image_count == $i)

                                <div class="col-md-4 mb-3 pr-0">
                                    <img class="card-img-top" src="{{$live_url.$mall_image->image_name}}" alt="image count {{$mall_image->image_count}}">
                                    {{--<a  href="javascript:;" data-href="" data-method="POST" class="btn-pi-delete" data-id="">--}}
                                    <a  href="javascript:;" data-href="{{route('malls.deletemallimage',['id'=>$mall_image->mall_image_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$mall_image->image_count}}">
                                        <span class="text-danger">{{__('Delete')}}</span>
                                    </a>
                                </div>
                                @php
                                    $empty = false;
                                @endphp
                            @endif

                        @endforeach
                        @endif

                        @if($empty)
                        {{--<div class="col-md-4 mb-3 pr-0">
                                <div class="upload-msg " style="height: 323px; max-width: 310px; width: 100%" >
                                    <div style="display: table-cell; vertical-align: middle;" onclick="$('#upload_{{$i}}').trigger('click');">Click to upload a file </div>
                                </div>
                            </div>--}}

                            <div class="col-md-4">
                                <form action="{{ route('malls.uploadimage') }}" class="dropzone" id="image_{{$i}}">
                                    @csrf
                                    <input type="hidden" name="image_count" value="{{ $i }}">
                                    <input type="hidden" name="mall_id" value="{{ $mall->mall_id }}">
                                </form>
                            </div>
                        @endif

                        {{--<input type="file" id="upload_{{$i}}" data-count="{{$i}}" class="imguploader" value="Choose a file" accept="image/*" style="display: none;" >--}}
                    @endfor



                </div>

             </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">

            <div class="card-header-malle">
                Mall Logo
            </div>


            <div class="card-body" id="promo-image-body2" data-sourceurl="{{route('malls.images',['mall__id'=>$mall->mall_id])}}">

                <div class="row" id="promo-image-content2">
                     <input type="text" id="selected_image1" style="display: none;">

                    @if($mall->mall_logo)
                        <div class="col-md-12 mb-3 pr-0">
                            <img class="card-img-top" src="{{ $logo_url.$mall->mall_logo}}" alt="{{$mall->mall_name}}" style="width: 200px !important;" >
                            <br>
                            <a  href="javascript:;" data-href="{{route('malls.logodeleteimage',['id'=>$mall->mall_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$mall->mall_id}}">
                                <span class="text-danger">{{__('Delete')}}</span>
                            </a>
                        </div>
                    @else
                        {{--<div class="col-md-12 mb-3 pr-0">
                            <div class="upload-msg " style="height: 320px; width: 100%" onclick="$('#upload_9').trigger('click');">
                                <div style="display: table-cell; vertical-align: middle;">Drop Files Here or click upload a photo </div>
                            </div>
                        </div>--}}

                        <div class="col-md-4">
                            <form action="{{ route('malls.uploadimage') }}" class="dropzone" id="my-awesome-dropzone">
                                @csrf
                                <input type="hidden" name="logo_image" value="9">
                                <input type="hidden" name="mall_id" value="{{ $mall->mall_id }}">
                            </form>
                        </div>
                    @endif


                    {{--<input type="file" id="upload_9" data-count="9" class="imguploader" value="Drop Files Here to click upload a photo" accept="image/*" style="display: none;" >--}}



                </div>

            </div>
        </div>
    </div>
</div>

@include('partials.image_model')

@endsection


@section('script')


<script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/croppie.css')}}">
<script type="text/javascript" src="{{asset('js/croppie.min.js')}}"></script>
<script>


    $( function() {


        Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            accept: function(file, done) {
                done();
            },
            init: function() {
                this.on("maxfilesexceeded", function(file){
                    toastr['error']('Upload one file only');

                });
                this.on("success", function(file, responseText) {
                    console.log('asdasdasdsad');
                    toastr.success(responseText);
                    console.log(responseText);
                    //ndow.location.reload();
                    //location.reload();
                });
            }
        };



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
                            if (data.image_count < 4) {
                                $('#promo-image-body1 #promo-image-content1').remove();
                                $("#promo-image-body1").load( $('#promo-image-body1').attr('data-sourceurl') +" #promo-image-content1");
                            }
                            else if (data.image_count == 9){
                                $('#promo-image-body2 #promo-image-content2').remove();
                                $("#promo-image-body2").load( $('#promo-image-body1').attr('data-sourceurl') +" #promo-image-content2");
                            } else{
                                $('#promo-image-body #promo-image-content').remove();
                                $("#promo-image-body").load( $('#promo-image-body').attr('data-sourceurl') +" #promo-image-content");
                            }
                            toastr.success(data.message);

                            window.location.reload();
                        }
                    }
                });

        });
    });



    </script>


@endsection
