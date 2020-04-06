@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                Images for   <span class="link_color"> {{ $location->merchant->merchant_name }} | {{ $location->mall->mall_name }} | {{ $location->merchant_location }}</span>

                <span style="float: right" class="link_color"><a href="{{route('merchants.show',[$location->merchant_id]) }}"> Back </a> </span>
            </div>
            <div class="card-body" id="promo-image-body1" data-sourceurl="">

                <div class="row" id="promo-image-content1">
                    <input type="text" id="selected_image" style="display: none;">
                    @for($i=1;$i<4;$i++)
                        @php
                            $empty = true;
                        @endphp

                        @if(!empty($locations_images))
                        @foreach($locations_images as $locations_image)
                            @if($locations_image->image_count == $i)

                                <div class="col-md-4 mb-3 pr-0">
                                    <img class="card-img-top fit-image" src="{{$live_url.$locations_image->image}}" alt="image count {{$locations_image->image_count}}">
                                    {{--<a  href="javascript:;" data-href="" data-method="POST" class="btn-pi-delete" data-id="">--}}
                                    <a  href="javascript:;" data-href="{{route('locations.deleteimage',['id'=>$locations_image->mli_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$locations_image->image_count}}">
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



                            <div class="col-md-4 mb-3 pr-0">
                                <form action="{{ route('locations.uploadimage') }}" class="dropzone" id="my-awesome-dropzone">
                                    @csrf
                                    <input type="hidden" name="image_count" value="{{$i}}">
                                    <input type="hidden" name="merchant_id" value="{{ @$location->merchant_id  }}">
                                    <input type="hidden" name="merchantlocation_id" value="{{ @$location->merchantlocation_id  }}">
                                </form>
                            </div>
                        @endif

                    @endfor


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


