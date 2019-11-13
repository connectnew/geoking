@extends('layouts.login')

@section('innercontent')

    <form class="login100-form validate-form loginform-text">

        <div class="card">
            <div class="card-header">{{ __('Verify Your Email Address') }}</div>

            <div class="card-body">

                <article class="card-body">

                    @include('layouts.partials.large-logo')

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    <p>{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.</p>

                </article>



            </div>
        </div>

    </form>

@endsection
