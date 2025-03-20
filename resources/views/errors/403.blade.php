@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', 'ACCESO PROHIBIDO')
@section('message')
    <div>
        <p>{{ __('messages.forbiden') }}</p>
    </div>
@endsection

