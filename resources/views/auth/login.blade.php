@extends('layouts.login')

@section('innercontent')

    <form class="login100-form validate-form loginform-text" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="card">
            <article class="card-body">
                @include('layouts.partials.large-logo')

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>

                        <input name="email" class="form-control pl-3 @error('email') is-invalid @enderror" placeholder="Email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    @if (Route::has('password.request'))
                        <a class="float-right blueLink forgot" href="{{ route('password.request') }}">Forgot?</a>
                    @endif
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-key"></i>
                            </span>
                        </div>

                        <input class="form-control pl-3 @error('password') is-invalid @enderror" placeholder="Password" type="password" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-4 mb-4">
                    <button type="submit" class="btn btn-block">{{ __('Sign In') }}</button>
                </div>

                <p class="text-center mt-2 d-inline-block w-100">
                    <a href="#" class="blueLink">{{ __('Log in with Google') }}</a>
                    &nbsp;
                    <img src="{{ asset('assets/images/gray-circle.jpg') }}">
                    &nbsp;
                    <a href="#" class="blueLink">{{ __('Log in with Microsoft') }}</a>
                </p>

                <p class="text-center">
                    <span class="light_grey">{{ __('No account?') }}</span>
                    <a href="{{ route('register') }}" class="blueLink">{{ __('Sign up for free') }}</a>
                </p>

                <p class="text-center mt-5">
                    <a href="{{ route('scan') }}" class="blueLink">{{ __('Scan without registration') }}</a>
                </p>

                {{--<p class="text-center official d-inline-block w-100 mt-5 font-weight-normal mb-4 pt-2">{{ __('Official partners') }}</p>--}}
                <br>

                <p class="text-center">
                    <img class="w-100" src="{{ asset('assets/images/gliflockup.png') }}">
                </p>

                <p class="text-center font-18 d-inline-block w-100 mt-4">
                    <a href="#" class="blackLink font-weight-normal">{{ __('Privacy') }}</a>
                    .
                    <a href="#" class="blackLink font-weight-normal">{{ __('Solutions') }}</a>
                    .
                    <a href="#" class="blackLink font-weight-normal">{{ __('Knowledge base') }}</a>
                    .
                    <a href="#" class="blackLink font-weight-normal">{{ __('Contact us') }}</a>
                </p>
            </article>
        </div>
    </form>

@endsection
