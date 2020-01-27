<div class="card-header-malle">
    {{--{{__('Manage Promotions')}}--}}


    {{--@if(isset($promo_id))--}}
        <a style="float:left;" href="{{route('country')}}">{{__('Manage Country')}}</a>
    {{--@endif


    @if(isset($promo_id))--}}
        <a style="margin-left: 50px" href="{{route('city')}}">{{__('Manage City')}}</a>

        <a style="margin-left: 50px" href="{{route('town')}}">{{__('Manage Town')}}</a>
    {{--@endif--}}
    {{--@if(isset($promo_id))
        <a style="float:right;" href="{{route('promotions.show',['promotions'=>$id, 'promo_id'=>$promo_id])}}">{{__('Back')}}</a>
    @endif--}}
</div>
