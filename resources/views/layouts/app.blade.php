
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Mall-E - Admin</title>

    <link href="{{asset('assets/images/logo/malle.png')}}" rel="icon" type="image">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" >
    <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/malle_style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/dropzone.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/jqueryui.css')}}" rel="stylesheet" type="text/css"> 
 
</head>

<body class="dashboard-body">
    <nav class="navbar navbar-light bg-malle">
        <div class="container">
            <a class="navbar-brand text-light" href="#">
                <img src="{{asset('assets/images/logo/rec.png')}}" width="110" height="50" class="d-inline-block align-top" alt="">
                | Admin Dashboard
            </a>
            <a class="my-2 btn-logout btn btn-danger bg-red" href="{{route('logout')}}">Logout</a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @include('partials.sidebar')
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-10">
                        <div class="card card-malle">
                            <div class="card-header-malle">Manage Malls</div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
 
</body>
</html>