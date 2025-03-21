@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', 'ERROR INTERNO DEL SERVIDOR')
@section('message')
    <div>
        <p>{{ __('messages.server_error') }}</p>
    </div>
@endsection
