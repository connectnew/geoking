@extends('layouts.dashboard')

@section('body')

@if (Session::has('msg'))
    <div class="alert alert-success">
        {{ Session::get("msg") }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="row mt-3">
    <div class="col-12 integrate-page">
        <div class="white-rounded-box no-corner">
            <div class="row mlr-15">
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <div class="gray-border-box">
                        <a href="{{ route('integration-google-1') }}">
                            <img src="{{ asset('assets/images/google-logo-xl.png') }}">
                        </a>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <div class="gray-border-box">
                        <img src="{{ asset('assets/images/fb-logo-xl.png') }}">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <div class="gray-border-box">
                        <img src="{{ asset('assets/images/foursquare-logo-xl.png') }}">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <div class="gray-border-box">
                        <img src="{{ asset('assets/images/bing-logo-xl.png') }}">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
