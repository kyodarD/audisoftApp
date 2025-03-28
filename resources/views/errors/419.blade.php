@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', 'PÁGINA CADUCADA')
@section('message')
    <div>
        <p>{{ __('messages.page_expired') }}</p>
    </div>
@endsection
