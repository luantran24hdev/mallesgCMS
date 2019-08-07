@if(isset($promo_id))
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Promotion Images')}}
            </div>
            <div class="card-body" id="promo-image-body" data-sourceurl="{{route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])}}"> 

                
                @if($promotion_images)
                <div class="row" id="promo-image-content">
                    <input type="text" id="selected_image" style="display: none;">
                    @for($i=1;$i<6;$i++)
                        @php
                            $empty = true;
                        @endphp
                        @foreach($promotion_images as $promotion_image)

                            @if($promotion_image->image_count == $i)
                                <div class="col-md-4 mb-3 pr-0"> 
                                    <img class="card-img-top fit-image" src="{{$live_url.$promotion_image->image_name}}" alt="image count {{$promotion_image->image_count}}">
                                    <a  href="javascript:;" data-href="{{route('promotions.deleteimage',['id'=>$promotion_image->mallpromo_image_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$promotion_image->mallpromo_image_id}}">
                                        <span class="text-danger">{{__('Delete')}}</span>
                                    </a>
                                </div>
                                @php
                                    $empty = false;
                                @endphp
                            @endif

                        @endforeach

                        @if($empty)
                            <div class="col-md-4 mb-3 pr-0"> 
                                <div class="upload-msg " style="height: 213px; max-width: 310px; width: 100%" onclick="$('#upload_{{$i}}').trigger('click');">
                                    <div style="display: table-cell; vertical-align: middle;">Click to upload a file </div>
                                </div>
                            </div>
                        @endif

                        <input type="file" id="upload_{{$i}}" data-count="{{$i}}" class="imguploader" value="Choose a file" accept="image/*" style="display: none;" >
                    @endfor

                    
 
                </div>
                @endif

             </div>
        </div>
    </div>
    
</div>
@endif
 