@extends('layouts.app')

@section('content')
    <div id="main-wrapper">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 login_wrapper">

                    @yield('innercontent')

                    <div class="login100-more" style="background-image: url({{ asset('assets/images/loginbg.jpg') }});"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
