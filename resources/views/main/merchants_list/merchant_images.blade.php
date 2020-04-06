
@extends('layouts.app')
@section('style')

    <style>
        .card{
            margin-bottom: 0px;
        }

    </style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                {{ $merchant->merchant_name }}
                <a href="{{route('merchants.list')}}">
                <span class="link_color" style="float: right">
                    Back
                </span>
                </a>
            </div>

            <div class="card-header-malle" style="background: white">
              Images For Website
            </div>


            <div class="card-body" id="promo-image-body" data-sourceurl="{{route('merchants.images',['merchant_id'=>$merchant->merchant_id])}}">

                <div class="row" id="promo-image-content">
                   {{-- <input type="text" id="selected_image" style="display: none;">--}}

                         @if($merchant->web_image)
                             <div class="col-md-12 mb-3 pr-0">
                                 <img class="card-img-top fit-image" src="{{ $live_url.$merchant->web_image}}" alt="image count">
                                 <a  href="javascript:;" data-href="{{route('merchants.webdeleteimage',['id'=>$merchant->merchant_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$merchant->merchant_id}}">
                                     <span class="text-danger">{{__('Delete')}}</span>
                                 </a>
                             </div>
                         @else

                            <div class="col-md-4">
                                <form action="{{ route('merchants.uploadimage') }}" class="dropzone" id="image_5">
                                    @csrf
                                    <input type="hidden" name="merchant_id" value="{{ $merchant->merchant_id }}">
                                </form>
                            </div>
                            {{--<div class="col-md-12 mb-3 pr-0">
                                <div class="upload-msg " style="height: 320px; width: 100%" onclick="$('#upload_5').trigger('click');">
                                    <div style="display: table-cell; vertical-align: middle;">Drop Files Here or click upload a photo </div>
                                </div>
                            </div>--}}
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
            <div class="card-body" id="promo-image-body1" data-sourceurl="{{route('merchants.images',['merchant_id'=>$merchant->merchant_id])}}">

                <div class="row" id="promo-image-content1">
                    <input type="text" id="selected_image" style="display: none;">
                    @for($i=1;$i<4;$i++)
                        @php
                            $empty = true;
                        @endphp

                        @if($merchant->merchantImage)
                        @foreach($merchant->merchantImage as $merchant_image)
                            @if($merchant_image->image_count == $i)

                                <div class="col-md-4 mb-3 pr-0">
                                    <img class="card-img-top" src="{{$live_url.$merchant_image->image_name}}" alt="image count {{$merchant_image->image_count}}">
                                    {{--<a  href="javascript:;" data-href="" data-method="POST" class="btn-pi-delete" data-id="">--}}
                                    <a  href="javascript:;" data-href="{{route('merchants.deletemallimage',['id'=>$merchant_image->merchant_image_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$merchant_image->image_count}}">
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
                                <form action="{{ route('merchants.uploadimage') }}" class="dropzone" id="image_{{$i}}">
                                    @csrf
                                    <input type="hidden" name="image_count" value="{{ $i }}">
                                    <input type="hidden" name="merchant_id" value="{{ $merchant->merchant_id  }}">
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
                Merchant Logo
            </div>
            <div class="card-body" id="promo-image-body2" data-sourceurl="{{route('merchants.images',['merchant_id'=>$merchant->merchant_id])}}">

                <div class="row" id="promo-image-content2">
                    <input type="text" id="selected_image" style="display: none;">

                @if(!empty($merchant->merchant_logo))
                        <div class="col-md-4 mb-3 pr-0">
                            <img class="card-img-top" src="{{$logo_live_url.$merchant->merchant_logo}}" alt="image count" style="width: 200px !important;">
                            {{--<a  href="javascript:;" data-href="" data-method="POST" class="btn-pi-delete" data-id="">--}}
                            <br>
                            <a  href="javascript:;" data-href="{{route('merchants.deletelogoimage',['id'=>$merchant->merchant_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$merchant->merchant_id}}">
                                <span class="text-danger">{{__('Delete')}}</span>
                            </a>
                        </div>



                       @else


                        <div class="col-md-4">
                            <form action="{{ route('merchants.uploadimage') }}" class="dropzone" id="my-awesome-dropzone">
                                @csrf
                                <input type="hidden" name="image_count" value="0">
                                <input type="hidden" name="merchant_id" value="{{ $merchant->merchant_id  }}">
                            </form>
                        </div>


                            {{--<div class="col-md-4 mb-3 pr-0">
                                <div class="upload-msg " style="height: 323px; max-width: 310px; width: 100%" >
                                    <div style="display: table-cell; vertical-align: middle;" onclick="$('#upload_0').trigger('click');">Click to upload a file </div>
                                </div>
                            </div>
                            <input type="file" id="upload_0" data-count="0" class="imguploader" value="Choose a file" accept="image/*" style="display: none;" >--}}
                    @endif



                </div>

            </div>
        </div>
    </div>
</div>


@include('partials.image_model')

@endsection


@section('script')
<script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
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
                    //console.log('asdasdasdsad');
                    toastr.success(responseText);
                    //console.log(responseText);
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
                            toastr.success(data.message);
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    }
                });

        });
    });



</script>


@endsection
