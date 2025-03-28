@extends('layouts.app')

@section('title','Editar Slider')

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
                            <form action="{{ route('sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <input type="text" name="titulo" class="form-control" value="{{ $slider->titulo }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea name="descripcion" class="form-control" required>{{ $slider->descripcion }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="img">Imagen</label>
                                    <input type="file" name="img" class="form-control">
                                    <img src="{{ $slider->img }}" alt="{{ $slider->titulo }}" width="100" style="margin-top: 10px;">
                                </div>
                                <button type="submit" class="btn btn-warning">Actualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
