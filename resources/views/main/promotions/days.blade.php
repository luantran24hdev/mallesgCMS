@if(isset($promo_id))
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Promotion Days')}}
            </div>
            <div class="card-body"> 
            <table class="table table-striped malle-table">
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
                                    <select name="{{$day}}" id="{{$day}}" class="promo_days dd-orange" data-href="{{route('promodays.update',['promodays' => $current_promo->promotion_days->pd_id])}}" data-method="PUT">
                                        <option value="Y" @if($current_promo->promotion_days->$day=='Y') selected @endif>Yes</option>
                                        <option value="N" @if($current_promo->promotion_days->$day=='N') selected @endif>No</option>
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
 