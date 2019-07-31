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
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/mall">Manage Malls</a></li>
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/merchant">Manage Merchants</a></li>
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/Deal">Manage Deals</a></li>
            <li class="list-group-item"><a class="malle-link" href="#">Manage Shops/Outlets</a></li>
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/company">Manage Company</a></li>
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/country">Manage Country</a></li>
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/ManageMasters/MallTypes">Manage Masters</a></li>
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/category">Manage Category</a></li>
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/dealcategory">Manage Sub Category</a></li>
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/Inquiry">Manage Inquiry</a></li>
            <li class="list-group-item"><a class="malle-link" href="https://admin.mall-e.net/Shopper">Manage Shoppers</a></li>
          </ul>
        
    </div>
</div>