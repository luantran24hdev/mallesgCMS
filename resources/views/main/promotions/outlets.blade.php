@if(isset($promo_id))
<div class="row">
  <div class="col-md-10">
    <div class="card card-malle">
      <div class="card-header-malle">
        {{__('Promotions in Outlets')}}
      </div>
      <div class="card-body">
        
        <form method="POST" action="{{route('promo-outlets.store')}}" id="addPromoTag">
          <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
          <input type="hidden" name="merchant_id" id="merchant_id" value="{{$id}}">
          <input type="hidden" name="tag_id" id="tag_id" value="">
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="mb-2 font-12">{{__('Mall Name')}}</label>
                <input type="text" name="mall_name" placeholder="Mall Name" id="mall_name" class="form-control" required="" data-autocompleturl="{{route('malls.search')}}">
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label class="mb-2 font-12">{{__('Location')}}</label>
                <select name="location" id="" class="form-control">
                  <option value="">--- Select ----</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion">{{__('Update')}}</button>
            </div>
          </div>
        </form>
        
        <div class="row">
          <div class="col-md-12"> 
            <table class="table table-striped malle-table " id="promotion-tag-table" data-sourceurl="{{route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])}}">
              <tbody>
                @foreach($current_promo->outlets as $outlet)
                <tr class="row-promo-tags" data-id="{{$outlet->pt_id}}">
                  <td>{{ optional($outlet->merchant)->merchant_name }}</td>  
                  <td>
                    {{ optional($outlet->merchantLocation())->merchant_location }}
                  </td>
                  <td>{{ optional($outlet->merchant)->merchant_address}}</td>  
                  <td>
                      <a href="javascript:;" data-href="{{route('promo-tags.destroy',['promotions'=>$promo_tag->pt_id])}}" data-method="DELETE" class="btn-pt-delete" data-id="{{$promo_tag->pt_id}}">
                          <span class="text-danger">{{__('Delete')}}</span>
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
@endif
