@extends('layouts.app')

@section('title','Detalle del Slider')

@section('content')

<div class="content-wrapper">
    <section class="content-header" style="text-align: right;">
        <div class="container-fluid">
        </div>
    </section>
    @include('layouts.partial.msg')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                        </div>
                        <div class="card-body">
                            <h3>{{ $slider->titulo }}</h3>
                            <p>{{ $slider->descripcion }}</p>
                            <img src="{{ $slider->img }}" alt="{{ $slider->titulo }}" width="300">
                            <a href="{{ route('sliders.index') }}" class="btn btn-primary" style="margin-top: 20px;">Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
