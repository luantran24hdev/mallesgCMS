@if(isset($promo_id))
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Promotion Category')}}
            </div>
            <div class="card-body">

                <form method="POST" action="{{route('promo-category.store')}}" id="addPromoCategory">
                <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
                <input type="hidden" name="merchant_id" id="merchant_id" value="{{$id}}">
                <input type="hidden" name="sub_category_id" id="sub_category_id" value="">

                    <div class="row prom_cat">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="category_select">
                                    @if(!empty($sub_category_lists))
                                        @foreach($sub_category_lists as $category)
                                            <option value="{{ $category->sub_category_id }}">{{ $category->Sub_Category_Name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>




                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion">{{__('Add Category')}}</button>
                            </div>
                        </div>



                    </div>
                </form>

                <div class="row ">
                    <div class="col-md-12"> 
                        <table class="table table-striped malle-table " id="promotion-category-table" data-sourceurl="{{route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])}}">
                        <thead>
                            <tr>
                                <th>{{__('Category Name')}}</th>
                                <th>{{__('Primary Cat')}}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php //print_r($promotion_categorys->master); die; ?>
                         @foreach($promotion_categorys as $promo_category)
                            <tr class="row-promo-tags" data-id="{{$promo_category->pc_id}}">

                                <?php $subcatname = \App\PromotionCategory::subCatName($promo_category->sub_category_id);

                                //print_r($subcatname); die;
                                ?>
                                <td> {{ $subcatname }} </td>
                                <td>
                                    <select name="primary_tag"  class="deal-status primary_tag" data-id="{{$promo_category->pc_id}}" data-href="{{route('promo-category.setprimary',['id'=>$promo_category->pc_id])}}" data-method="POST">
                                        <option value="N" @if($promo_category->primary_cat=="N") selected @endif>No</option>
                                        <option value="Y" @if($promo_category->primary_cat=="Y") selected @endif>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <a  href="javascript:;" data-href="{{route('promo-category.destroy',['promotions'=>$promo_category->pc_id])}}" data-method="DELETE" class="btn-pt-delete" data-id="{{$promo_category->pc_id}}">
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
 