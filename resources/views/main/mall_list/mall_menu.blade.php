<div class="card-header-malle">
    {{--{{__('Manage Promotions')}}--}}


    {{--@if(isset($promo_id))--}}
        <a style="float:left;" href="{{route('malls')}}">{{__('Manage Malls')}} ({{ @$total_mall }})</a>
    {{--@endif


    @if(isset($promo_id))--}}
        <a style="margin-left: 50px" href="{{route('mall-type')}}">{{__('Mall Types')}}</a>

        <a style="margin-left: 50px" href="{{route('mall-owner')}}">{{__('Mall Owners')}}</a>
    {{--@endif--}}
    {{--@if(isset($promo_id))
        <a style="float:right;" href="{{route('promotions.show',['promotions'=>$id, 'promo_id'=>$promo_id])}}">{{__('Back')}}</a>
    @endif--}}
</div>


