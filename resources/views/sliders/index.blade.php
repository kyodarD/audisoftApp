@extends('layouts.app')

@section('title','Listado De Sliders')

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
                            @can('sliders.create')
                                <a href="{{ route('sliders.create') }}" class="btn btn-primary float-right" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">Id</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Imagen</th>
                                        <th width="30px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sliders as $slider)
                                    <tr>
                                        <td>{{ $slider->id }}</td>
                                        <td>{{ $slider->titulo }}</td>
                                        <td>{{ Str::limit($slider->descripcion, 50) }}</td>
                                        <td>
                                            @if ($slider->img != null)
                                                <img src="{{ asset('storage/'.$slider->img) }}" alt="{{ $slider->titulo }}" style="width:100px; height:auto;" />
                                            @else                                              
                                                <span>No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('sliders.edit')
                                                <a href="{{ route('sliders.edit', $slider) }}" class="btn btn-info btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('sliders.delete')
                                                <form action="{{ route('sliders.destroy', $slider) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash"></i></button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 </div>
@endsection
