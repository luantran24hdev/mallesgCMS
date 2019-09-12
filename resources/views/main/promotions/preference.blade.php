@if(isset($promo_id))
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Preference Tags')}}
            </div>
            <div class="card-body">

                <form method="POST" action="{{route('promotion.preference.store')}}" id="addPromoPreference">
                <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
                    <input type="hidden" name="merchant_id" id="merchant_id" value="{{$id}}">
                <input type="hidden" name="preference_id" id="preference_id" value="">

                    <div class="row prom_cat">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="preference_select">
                                    @if(!empty($preference_master_lists))
                                        @foreach($preference_master_lists as $preference_master)
                                            <option value="{{ $preference_master->preference_id }}">{{ $preference_master->preference_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>




                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion">{{__('Add Preference')}}</button>
                            </div>
                        </div>



                    </div>
                </form>

                <div class="row ">
                    <div class="col-md-12"> 
                        <table class="table table-striped malle-table " id="promotion-preference-table" data-sourceurl="{{route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])}}">
                        <thead>
                            <tr>
                                <th>{{__('Promotions Name')}}</th>
                                <th>{{__('Primary Cat')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php //print_r($promotion_categorys->master); die; ?>
                         @foreach($preference_lists as $preference_list)
                            <tr class="row-promo-tags" data-id="{{$preference_list->pp_id}}">

                                <td> {{ @$preference_list->preference->preference_name }} </td>
                                <td>
                                    <select name="primary_tag"  class="deal-status primary_tag" data-id="{{$preference_list->pp_id}}" data-href="{{route('promotion.preference.setprimary',['id'=>$preference_list->pp_id])}}" data-method="POST">
                                        <option value="N" @if($preference_list->primary_tag=="N") selected @endif>No</option>
                                        <option value="Y" @if($preference_list->primary_tag=="Y") selected @endif>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <a  href="javascript:;" data-href="{{route('promotion.preference.destroy',['promotions'=>$preference_list->pp_id])}}" data-method="DELETE" class="btn-pt-delete" data-id="{{$preference_list->pp_id}}">
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
 