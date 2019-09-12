@if(isset($promo_id))
<div class="row">
    <div class="col-md-12">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Promotion Outlate')}}
            </div>
            <div class="card-body">

                <form method="POST" action="{{route('promo.outlate.store')}}" id="addPromoOutlateDay">
                <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
                    <input type="hidden" name="po_id" id="outlate_id" value="{{$outlate_data->po_id}}">
                <input type="hidden" name="merchant_id" id="merchant_id" value="{{$id}}">
                <input type="hidden" name="dow_id" id="dow_id" value="">

                    <div class="row prom_outlate">

                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="week_select">
                                    @if(!empty($daysofweek))
                                        @foreach($daysofweek as $weekday)
                                            <option value="{{ $weekday->dow_id }}">{{ $weekday->dow_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion">{{__('Update')}}</button>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="row ">
                    <div class="col-md-12"> 
                        <table class="table table-striped malle-table " id="promotion-outday-table" data-sourceurl="{{route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlate_data->po_id,'promo_id'=>$promo_id])}}">
                        <thead>
                            <tr>
                                <th>{{__('Promo Name')}}</th>
                                <th>{{__('Which Mall')}}</th>
                                <th>{{__('which Day')}}</th>
                                <th>{{__('Action')}}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                         @foreach($promotions_out_days as $promotions_out_day)
                            <tr class="row-promo-out-day" data-id="{{$promotions_out_day->pod_id}}">
                                <td>{{ $promotions_out_day->promomaster->promo_name }} </td>
                                <td> {{ $promotions_out_day->outlatedata->mall->mall_name }}</td>
                                <td> {{ @$promotions_out_day->dayweek->dow_name }}</td>
                                <td>
                                     <a  href="javascript:;" data-href="{{route('promo.outlate.day.destroy',[$promotions_out_day->pod_id])}}" data-method="DELETE" class="btn-delete" data-id="{{$promotions_out_day->pod_id}}">
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
 