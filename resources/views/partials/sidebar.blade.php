<div class="mt-4 col-lg-2 col-md-2 col-sm-2 col-xs-2">
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
            <li class="list-group-item"><a class="malle-link" href="{{route('service.index')}}">{{__('Services')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('category-tags')}}">{{__('Category Tags')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('manage.inquiry')}}">{{__('Manage Inquiry')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('manage.shoppers')}}">{{__('Manage Shoppers')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('country')}}">{{__('Manage Country')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('level')}}">{{__('Manage Level')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('manage-age')}}">{{__('Manage Age Group')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('meal-group')}}">{{__('Manage Meal Group')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('user-setting')}}">{{__('User Setting')}}</a></li>
            <li class="list-group-item"><a class="malle-link" href="{{route('fnb')}}">{{__('F & B List')}}</a></li>
        </ul>

    </div>
</div>
