@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', 'NO AUTORIZADO')
@section('message')
    <div>
        <p>{{ __('messages.unauthorized') }}</p>
    </div>
@endsection
