@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', 'PÁGINA NO ENCONTRADA')
@section('message')
    <div>
        <p>{{ __('messages.not_found_message') }}</p>
    </div>
@endsection
