@if(isset($promo_id))
<div class="row">
    <div class="col-md-12">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Promotion Days Of Week')}}
            </div>
            <div class="card-body"> 
            <table class="table table-striped malle-table" data-sourceurl="{{route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlate_data->po_id,'promo_id'=>$promo_id])}}" id="outlate-day-table">
                <thead>
                    <tr>
                        @if($daysofweek) 
                            @foreach($daysofweek as $day)
                                <th>{{ucwords($day)}}</th>
                            @endforeach
                        @endif 
                    </tr>
            </thead>
                <tbody>
                    <tr>                        
                         @if($daysofweek) 
                            @foreach($daysofweek as $day)
                                <td>
                                    <select name="{{$day}}" id="{{$day}}" class="promo_days dd-orange" data-href="{{route('promo-outlets-days.update',['out_id' => $outlate_data->po_id])}}" data-method="PUT">
                                        <option value="N" @if(@$outlate_data->promotion_days->$day=='N') selected @endif>No</option>
                                        <option value="Y" @if(@$outlate_data->promotion_days->$day=='Y') selected @endif>Yes</option>
                                    </select>
                                </td>
                            @endforeach
                        @endif                     
                    </tr>
                </tbody>
            </table>
                
            </div>
        </div>
    </div>
</div>
@endif
 