@if(isset($promo_id))
<div class="row">
  <div class="col-md-10">
    <div class="card card-malle">
      <div class="card-header-malle">
        {{__('Promotions in Outlets')}}
      </div>
      <div class="card-body">
        
        <form method="POST" action="{{route('promo-outlets.store')}}" id="addOutlates">
          <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
          <input type="hidden" name="merchant_id" id="merchant_id" value="{{$id}}">
          <input type="hidden" name="mall_id" id="mall_id" value="">

          
          <div class="row prom_out">
            <div class="col-md-4">
                <div class="form-group">
                  <label class="mb-2 font-12">{{__('Search Mall Name')}}</label>
                <select id="prom_out">
                    @if(!empty($mall_lists))
                        @foreach($mall_lists as $mall)
                            <option value="{{ $mall['mall_id'] }}">{{ $mall['mall_name'] }}</option>
                        @endforeach
                    @endif
                </select>
                </div>
              {{--<div class="form-group">
                <label class="mb-2 font-12">{{__('Mall Name')}}</label>
                <input type="text"  placeholder="Mall Name" id="mall_name" class="form-control" required="" data-autocompleturl="{{route('malls.search')}}">
              </div>--}}

            </div>


            
            <div class="col-md-3">
              <div class="form-group">
                <label class="mb-2 font-12">{{__('Location')}}</label>
                <select name="merchantlocation_id" id="locations" class="form-control">
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
            <table class="table table-striped malle-table " id="promotion-outlate-table" data-sourceurl="{{route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])}}">
             <thead>
             <tr>
               <th>Promotional Name</th>
               <th>Mall Name</th>
               <th>Location</th>
               <th>Level</th>
               <th>Live</th>
               <th>Featured</th>
               <th>Redeem</th>
               <th>Action</th>

             </tr>
             </thead>
              <tbody>

                @if(isset($current_promo->outlets))
                @foreach($current_promo->outlets as $outlet)
                <tr class="row-promotion" data-id="{{$outlet->po_id}}">
                  <td>{{ optional($current_promo)->promo_name }}</td>
                  <td>{{ optional($outlet->mall)->mall_name }}</td>
                  <td>
                    {{ optional($outlet->merchantLocation)->merchant_location }}
                  </td>
                  <td>
                    {{ optional($outlet->merchantLocation)->floor['level'] }}
                  </td>
                  <td>
                    <select name="live" id="" class="column_update dd-orange" data-href="{{route('promo-outlets.update',['promo_active' => $outlet->po_id])}}" data-method="PUT">
                      <option value="Y" @if($outlet->live=='Y') selected @endif>Yes</option>
                      <option value="N" @if($outlet->live=='N') selected @endif>No</option>
                    </select>
                  </td>
                  <td>
                   <select name="featured" id="" class="column_update dd-orange" data-href="{{route('promo-outlets.update',['promo_active' => $outlet->po_id])}}" data-method="PUT">
                      <option value="Y" @if($outlet->featured=='Y') selected @endif>Yes</option>
                      <option value="N" @if($outlet->featured=='N') selected @endif>No</option>
                    </select>
                  </td>
                  <td>
                    <select name="redeem" id="" class="column_update dd-orange" data-href="{{route('promo-outlets.update',['promo_active' => $outlet->po_id])}}" data-method="PUT">
                      <option value="Y" @if($outlet->redeem=='Y') selected @endif>Yes</option>
                      <option value="N" @if($outlet->redeem=='N') selected @endif>No</option>
                    </select>
                  </td>
                  <td>

                    <a href="{{route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlet->po_id,'promo_id'=>$outlet->promo_id])}}" data="2" class="btn-edit"><span class="text-success">Edit</span></a>
                    |
                    &nbsp;
                    <a  href="javascript:;" data-href="{{route('promo-outlets.destroy',['promo_active' => $outlet->po_id])}}" data-method="DELETE" class="btn-delete" data-id="{{$outlet->po_id}}">
                      <span class="text-danger">Delete</span>
                    </a>
                  </td>
                </tr>
                @endforeach
                  @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
