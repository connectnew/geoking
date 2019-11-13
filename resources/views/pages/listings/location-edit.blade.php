@extends('layouts.dashboard')

@section('body')

<edit-location :location="{{$location}}" tab="{{ app('request')->input('tab') }}"></edit-location>

@endsection