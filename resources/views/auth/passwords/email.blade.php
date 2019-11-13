@extends('layouts.login')

@section('innercontent')


    <form method="POST" action="{{ route('password.email') }}" class="login100-form validate-form loginform-text">
        @csrf

        <div class="card">
            <div class="card-header">{{ __('Reset Password') }}</div>

            <article class="card-body">

                @include('layouts.partials.large-logo')

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>

                        <input id="email" type="email" class="form-control pl-3  @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email"
                               placeholder="{{ __('E-Mail Address') }}">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-4 mb-4">
                    <button type="submit" class="btn btn-block">{{ __('Send Password Reset Link') }}</button>
                </div>

            </article>
        </div>
    </form>

@endsection
