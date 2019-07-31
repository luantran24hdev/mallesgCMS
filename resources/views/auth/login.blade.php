@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="card card-container">
        <img class="img-card-admin" src="{{asset('assets/images/logo/malle.png')}}">
        <form class="form-admin-login" method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf
            <div class="form-group">
                <input type="email" name="email_id" placeholder="Email Address" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" class="form-control" required><!-- 
                <a href="#" class="forgot-password " data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password?</a> -->

            </div>
 
            <div class="form-group pt-4">
                <button type="submit" class="btn btn-block btn-sign-in">Sign in</button>
            </div>
        </form>
    </div>
</div>
@endsection
