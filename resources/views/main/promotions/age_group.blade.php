@if(isset($promo_id))
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Age Groups')}}
            </div>
            <div class="card-body">

                <form method="POST" action="{{route('promotion.agegroup.store')}}" id="addPromoAge">
                <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
                    <input type="hidden" name="merchant_id" id="merchant_id" value="{{$id}}">
                    <input type="hidden" name="ag_id" id="ag_id" value="">


                    <div class="row prom_cat">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="age_select">
                                    @if(!empty($manage_age_lists))
                                        @foreach($manage_age_lists as $manage_age)
                                            <option value="{{ $manage_age->ag_id }}">{{ $manage_age->age_group_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion">{{__('Update')}}</button>
                            </div>
                        </div>



                    </div>
                </form>

                <div class="row ">
                    <div class="col-md-12"> 
                        <table class="table table-striped malle-table " id="promotion-age-table" data-sourceurl="{{route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])}}">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{__('Age Group Name')}}</th>
                                <th>{{__('Age Group')}}</th>
                                <th>{{__('Primary Cat')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php //print_r($promotion_categorys->master); die; ?>
                         @foreach($promo_age_groups as $promo_age_group)
                            <tr class="row-promo-tags" data-id="{{$promo_age_group->pag_id}}">
                                <td>
                                    @if(!empty($promo_age_group->age_groups->ag_image))
                                        <img src="{{ $live_url_age.$promo_age_group->age_group->ag_image }}" width="50px" height="50px">
                                    @else
                                        <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>
                                    @endif
                                </td>

                                <td> {{ @$promo_age_group->age_group->age_group_name }} </td>
                                <td> {{ @$promo_age_group->age_group->age_group }} </td>

                                <td>
                                    <select name="primary_cat"  class="deal-status primary_tag" data-id="{{$promo_age_group->pag_id}}" data-href="{{route('promotion.agegroup.setprimary',['id'=>$promo_age_group->pag_id])}}" data-method="POST">
                                        <option value="N" @if($promo_age_group->primary_cat=="N") selected @endif>No</option>
                                        <option value="Y" @if($promo_age_group->primary_cat=="Y") selected @endif>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <a  href="javascript:;" data-href="{{route('promotion.agegroup.destroy',['promotions'=>$promo_age_group->pag_id])}}" data-method="DELETE" class="btn-pt-delete" data-id="{{$promo_age_group->pag_id}}">
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
 