@extends('layouts.login')

@section('innercontent')

    <form class="login100-form validate-form loginform-text" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="card">
            <article class="card-body">

                @include('layouts.partials.large-logo')

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>

                        <input id="first_name" type="text" class="form-control pl-3 @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" placeholder="First Name">

                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>

                        <input id="last_name" type="text" class="form-control pl-3 @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" placeholder="Last Name">

                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>

                        <input id="email" type="email" class="form-control pl-3  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-key"></i>
                            </span>
                        </div>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password (minimum 8 characters)" minlength="8">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-key"></i>
                            </span>
                        </div>

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" minlength="8">
                    </div>
                </div>

                <div class="form-group mt-4 mb-4">
                    <button type="submit" class="btn btn-block">Register</button>
                </div>

                <p class="text-center">
                    <span class="light_grey"></span>
                    <a href="{{ route('login') }}" class="blueLink">Back To Login</a>
                </p>
                {{--<p class="text-center official d-inline-block w-100 mt-5 font-weight-normal mb-4 pt-2">Official partners</p>--}}
                <br>
                <p class="text-center">
                    <img class="w-100" src="{{ asset('assets/images/gliflockup.png') }}">
                </p>
                <p class="text-center font-18 d-inline-block w-100 mt-4">
                    <a href="#" class="blackLink font-weight-normal">Privacy</a>
                    .
                    <a href="#" class="blackLink font-weight-normal">Solutions</a>
                    .
                    <a href="#" class="blackLink font-weight-normal">Knowledge base</a>
                    .
                    <a href="#" class="blackLink font-weight-normal">Contact us</a>
                </p>
            </article>
        </div>
    </form>

@endsection
