@if(isset($promo_id))
<div class="row">
    <div class="col-md-12">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Promotions- Time')}}
            </div>
            <div class="card-body">

                <form method="POST" action="{{route('promo.outlate.time.store')}}" id="addPromoOutlateTime">
                <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
                    <input type="hidden" name="po_id" id="outlate_id" value="{{$outlate_data->po_id}}">
                <input type="hidden" name="dow_id" id="time_dow_id" value="">
                    <input type="hidden" name="tt_id" id="tt_id" value="">

                    <div class="row prom_outlate">

                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="day_select">
                                    @if(!empty($day_selects))
                                        @foreach($day_selects as $day_select)
                                            <option value="{{ $day_select->dow_id }}">{{ $day_select->dow_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="time_select">
                                    @if(!empty($time_data))
                                        @foreach($time_data as $time)
                                            <option value="{{ $time->tt_id }}">{{ $time->tt_name }}</option>
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
                        <table class="table table-striped malle-table " id="promotion-outtime-table" data-sourceurl="{{route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlate_data->po_id,'promo_id'=>$promo_id])}}">
                        <thead>
                            <tr>
                                <th>{{__('Day')}}</th>
                                <th>{{__('Time')}}</th>
                                <th>{{__('Action')}}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                         @foreach($promotion_outlate_time as $promotion_out_time)
                            <tr class="row-promo-out-day" data-id="{{$promotion_out_time->pot_id}}">

                                <td> {{ @$promotion_out_time->dayweek->dow_name }}</td>
                                <td>{{ @$promotion_out_time->timeTag->tt_name }} </td>
                                <td>
                                     <a  href="javascript:;" data-href="{{route('promo.outlate.time.destroy',[$promotion_out_time->pot_id])}}" data-method="DELETE" class="btn-delete" data-id="{{$promotion_out_time->pot_id}}">
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
 