<div class="card-header-malle">
    {{--{{__('Manage Promotions')}}--}}


    {{--@if(isset($promo_id))--}}
        <a style="float:left;" href="{{route('time-tags')}}">{{__('Time Group')}}</a>
    {{--@endif


    @if(isset($promo_id))--}}
        <a style="margin-left: 50px" href="{{route('timetag.tags')}}">{{__('Time Tag')}}</a>

        <a style="margin-left: 50px" href="{{route('timetag.tags.group')}}">{{__('Time Tags Grouping')}}</a>
    {{--@endif--}}
    {{--@if(isset($promo_id))
        <a style="float:right;" href="{{route('promotions.show',['promotions'=>$id, 'promo_id'=>$promo_id])}}">{{__('Back')}}</a>
    @endif--}}
</div>