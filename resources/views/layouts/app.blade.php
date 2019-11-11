
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Mall-E - Admin2</title>

    <link href="{{asset('assets/images/logo/malle.png')}}" rel="icon" type="image">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />


    <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/dropzone.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/jqueryui.css')}}" rel="stylesheet" type="text/css">     
    <link href="{{asset('assets/css/malle_style.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .link_color{
            color: blue;
        }
    </style>

    @yield('style')
 
</head>

<body class="dashboard-body">
    <div id="app">
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
    </div>
</body>
{{--<script type="text/javascript" src="{{ mix('js/app.js')}}"></script>--}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
{{--<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>--}}

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/bootbox.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/bootbox.locales.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/defaults.js')}}"></script>
@yield('script')
</html>