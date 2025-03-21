@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', 'DEMASIADAS PETICIONES')
@section('message')
    <div>
        <p>{{ __('messages.too_many_requests') }}</p>
    </div>
@endsection
