@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', 'SERVIDOR NO DISPONIBLE')
@section('message')
    <div>
        <p>{{ __('messages.service_unavailable') }}</p>
    </div>
@endsection
