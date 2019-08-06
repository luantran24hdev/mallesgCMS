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
                    @foreach($promotion_images as $image) 
                        <div class="col-md-4 mb-3 pr-0"> 
                            <img class="card-img-top fit-image" src="https://admin.mall-e.net/promos/{{$image->image_name}}" alt="Card image cap">
                         </div>
                    @endforeach

                    <div class="upload-msg ml-3" style="height: 213px; max-width: 310px; width: 100%" onclick="$('#upload').trigger('click');"">
                        <div style="display: table-cell; vertical-align: middle;">Click to upload a file </div>
                    </div>
 
                </div>
                @endif

             </div>
        </div>
    </div>
    <input type="file" id="upload" value="Choose a file" accept="image/*" style="visibility: hidden;" >
</div>
@endif
 