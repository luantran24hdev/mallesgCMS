<div class="col-md-2 mt-4">
    <div class="sidebar">
        @if(Auth::user())
            <div class="container">
                <div class="row">
                    <h5>Hi ! <span class="text-info">{{Auth::user()->short_name}}</span></h5><br>
                    <div class="text-email">{{Auth::user()->email_id}}</div>
                </div><hr>
            </div>
        @endif
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><a class="malle-link" href="{{route('malls')}}">{{__('Mall List')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('merchants.list')}}">{{__('Merchants List')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('merchants')}}">{{__('Merchants in Outlets')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('promotions')}}">{{__('New Promotions')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('time-tags')}}">{{__('Time Tags')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('preference-tags')}}">{{__('Preference Tags')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('discount-tags')}}">{{__('Discount Tags')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('category-tags')}}">{{__('Category Tags')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('manage.inquiry')}}">{{__('Manage Inquiry')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('manage.shoppers')}}">{{__('Manage Shoppers')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('country')}}">{{__('Manage Country')}}</a></li>
        </ul>

    </div>
</div>
