@if(isset($promo_id))
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Promotion Meals')}}
            </div>
            <div class="card-body">

                <form method="POST" action="{{route('promotion.mealgroup.store')}}" id="addMeal">
                <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
                    <input type="hidden" name="merchant_id" id="merchant_id" value="{{$id}}">
                    <input type="hidden" name="mg_id" id="mg_id" value="">


                    <div class="row prom_cat">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="mg_select">
                                    @if(!empty($manage_meal_lists))
                                        @foreach($manage_meal_lists as $manage_meal)
                                            <option value="{{ $manage_meal->mg_id }}">{{ $manage_meal->meal_name }}</option>
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
                        <table class="table table-striped malle-table " id="promotion-meal-table" data-sourceurl="{{route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])}}">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{__('Meal Name')}}</th>
                                <th>{{__('Primary Cat')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php //print_r($promotion_categorys->master); die; ?>
                         @foreach($promo_meal_groups as $promo_meal_group)
                            <tr class="row-promo-tags" data-id="{{$promo_meal_group->pmg_id}}">
                                <td>
                                    @if(!empty($promo_meal_group->meal_group->meal_image))
                                        <img src="{{ $live_url_age.$promo_meal_group->meal_group->meal_image }}" width="50px" height="50px">
                                    @else
                                        <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>
                                    @endif
                                </td>

                                <td> {{ @$promo_meal_group->meal_group->meal_name }} </td>

                                <td>
                                    <select name="primary_cat"  class="deal-status primary_tag" data-id="{{$promo_meal_group->pmg_id}}" data-href="{{route('promotion.mealgroup.setprimary',['id'=>$promo_meal_group->pmg_id])}}" data-method="POST">
                                        <option value="N" @if($promo_meal_group->primary_cat=="N") selected @endif>No</option>
                                        <option value="Y" @if($promo_meal_group->primary_cat=="Y") selected @endif>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <a  href="javascript:;" data-href="{{route('promotion.mealgroup.destroy',['promotions'=>$promo_meal_group->pmg_id])}}" data-method="DELETE" class="btn-pt-delete" data-id="{{$promo_meal_group->pmg_id}}">
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
 