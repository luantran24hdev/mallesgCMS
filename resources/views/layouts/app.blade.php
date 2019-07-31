
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Mall-E - Admin2</title>

    <link href="{{asset('assets/images/logo/malle.png')}}" rel="icon" type="image">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" >
    <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/malle_style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/dropzone.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/jqueryui.css')}}" rel="stylesheet" type="text/css"> 
    @yield('style')
 
</head>

<body class="dashboard-body">
    <nav class="navbar navbar-light bg-malle">
        <div class="container">
            <a class="navbar-brand text-light" href="{{route('home')}}">
                <img src="{{asset('assets/images/logo/rec.png')}}" width="110" height="50" class="d-inline-block align-top" alt="">
                | {{__('Admin Dashboard')}}
            </a>
            <a class="my-2 btn-logout btn btn-danger bg-red" href="{{route('logout')}}">{{__('Logout')}}</a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @include('partials.sidebar')
            <div class="col-md-10">
                @yield('content')
            </div>
        </div>

    </div>
 
</body>
<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jqueryui.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    toastr.options.showEasing = 'swing';
    toastr.options.progressBar = true;
</script>
@yield('script')
</html>