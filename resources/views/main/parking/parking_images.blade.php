<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                Images for Event
            </div>
            <div class="card-body" id="promo-image-body1" data-sourceurl="{{route('mall-parking.edit',[$parking->mall_id])}}">

                <div class="row" id="promo-image-content1">
                    <input type="text" id="selected_image" style="display: none;">
                    @for($i=1;$i<4;$i++)
                        @php
                            $empty = true;
                        @endphp

                        @if(!empty($parking_images))
                        @foreach($parking_images as $parking_image)
                            @if($parking_image->image_count == $i)

                                <div class="col-md-4 mb-3 pr-0">
                                    <img class="card-img-top fit-image" src="{{$live_url.$parking_image->parking_image}}" alt="image count {{$parking_image->image_count}}">
                                    {{--<a  href="javascript:;" data-href="" data-method="POST" class="btn-pi-delete" data-id="">--}}
                                    <a  href="javascript:;" data-href="{{route('parking.deleteimage',['id'=>$parking_image->pi_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$parking_image->image_count}}">
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
                                <div class="upload-msg " style="height: 200px; max-width: 310px; width: 100%" >
                                    <div style="display: table-cell; vertical-align: middle;" onclick="$('#upload_{{$i}}').trigger('click');">Click to upload a file </div>
                                </div>
                            </div>
                        @endif

                        <input type="file" id="upload_{{$i}}" data-count="{{$i}}" class="imguploader" value="Choose a file" accept="image/*" style="display: none;" >
                    @endfor

                    
 
                </div>

             </div>
        </div>
    </div>
</div>


