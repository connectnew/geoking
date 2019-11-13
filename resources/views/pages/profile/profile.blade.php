@extends('layouts.app')

@section('content')

<my-profile :forms="{{ json_encode(Session::get('form')) }}"></my-profile>

@endsection
