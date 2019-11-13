@extends('layouts.dashboard')

@section('body')

    <sources :user="{{ Auth::user() }}" :locations="{{ Auth::user()->ownsLocations }}"></sources>

    <add-many></add-many>
    <simple-alert :alert_id="'simple-alert-source'" :alert_btn="'Close'"></simple-alert>

@endsection