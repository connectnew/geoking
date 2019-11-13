@extends('layouts.login')

@section('innercontent')

    <form method="POST" action="{{ route('password.update') }}" class="login100-form validate-form loginform-text">
        @csrf

        <div class="card">
            <div class="card-header">{{ __('Reset Password') }}</div>

            <div class="card-body">

                <article class="card-body">

                    @include('layouts.partials.large-logo')

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}" required>

                    @error('email')
                        <div class="alert alert-success" role="alert">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-key"></i>
                                </span>
                            </div>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" required autocomplete="new-password">

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

                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                        </div>
                    </div>

                    <div class="form-group mt-4 mb-4">
                        <button type="submit" class="btn btn-block">{{ __('Reset Password') }}</button>
                    </div>

                </article>

            </div>
        </div>

    </form>

@endsection
