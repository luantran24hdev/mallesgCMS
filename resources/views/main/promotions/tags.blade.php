@if(isset($promo_id))
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                    {{__('Promotion Tags')}}
                </div>
                <div class="card-body">

                    <form method="POST" action="{{route('promo-tags.store')}}" id="addPromoTag">
                        <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
                        <input type="hidden" name="merchant_id" id="merchant_id" value="{{$id}}">
                        <input type="hidden" name="tag_id" id="tag_id" value="">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Tag Name')}}</label>
                                    <input type="text" name="tag_name" placeholder="Tag Name" id="tag_name"
                                           class="form-control" required=""
                                           jautocom-sourceurl="{{route('promo-tags.search')}}"
                                           jautocom-targetid="tag_id">
                                </div>
                            </div>


                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary col-md-12 top-t"
                                        id="btnMerchantPromotion">{{__('Add Tag')}}</button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped malle-table " id="promotion-tag-table"
                                   data-sourceurl="{{route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])}}">
                                <thead>
                                <tr>
                                    <th>{{__('Tag Name')}}</th>
                                    <th>{{__('Primary Tag')}}</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($promotion_tags as $promo_tag)
                                    <tr class="row-promo-tags" data-id="{{$promo_tag->pt_id}}">
                                        <td> {{$promo_tag->master->tag_name}}</td>
                                        <td>
                                            <select name="primary_tag" class="deal-status primary_tag"
                                                    data-id="{{$promo_tag->pt_id}}"
                                                    data-href="{{route('promo-tags.setprimary',['id'=>$promo_tag->pt_id])}}"
                                                    data-method="POST">
                                                <option value="N" @if($promo_tag->primary_tag!="Y") selected @endif>No
                                                </option>
                                                <option value="Y" @if($promo_tag->primary_tag=="Y") selected @endif>
                                                    Yes
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <a href="javascript:;"
                                               data-href="{{route('promo-tags.destroy',['promotions'=>$promo_tag->pt_id])}}"
                                               data-method="DELETE" class="btn-pt-delete"
                                               data-id="{{$promo_tag->pt_id}}">
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
    @include('partials.delete_model')

@endif
