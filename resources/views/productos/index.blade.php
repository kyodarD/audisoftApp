@extends('layouts.app')

@section('title', 'Listado De Productos')

@section('content')

<div class="content-wrapper">
    <section class="content-header" style="text-align: right;">
        <div class="container-fluid">
        </div>
    </section>
    @include('layouts.partial.msg')

	
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                            @can('productos.create')
                                <a href="{{ route('productos.create') }}" class="btn btn-primary float-right" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">ID</th>
                                        <th>Categoria</th>
                                        <th>Proveedor</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Fecha De Vencimiento</th>
                                        <th>Imagen</th>
                                        <th width="60px">Estado</th>
                                        <th width="90px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->id }}</td>
                                        <td>{{ $producto->categoria->nombre }}</td>
                                        <td>{{ $producto->proveedor->nombre ?? 'N/A' }}</td> <!-- Se muestra el nombre del proveedor -->
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->descripcion }}</td>
                                        <td>{{ $producto->precio }}</td>
                                        <td>{{ $producto->stock }}</td>
                                        <td>{{ $producto->fecha_vencimiento }}</td>
                                        <td>
                                            @if ($producto->img != null)
                                                <img src="{{ asset('uploads/productos/'.$producto->img) }}" alt="{{ $producto->titulo }}" style="width:100px; height:auto;" />
                                            @else                                              
                                                <span>No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('productos.cambioestadodepartamento')
                                                <input data-type="producto" data-id="{{ $producto->id }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" 
                                                data-toggle="toggle" data-on="Activo" data-off="Inactivo" {{ $producto->estado ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('productos.edit')
                                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-info btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('productos.destroy')
                                                <form class="d-inline delete-form" action="{{ route('productos.destroy', $producto) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
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
