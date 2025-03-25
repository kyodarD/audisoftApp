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
                        <div class="card-header bg-secondary"
                            style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">

                            @yield('title')

                            {{-- Crear Producto: permiso "crear productos" --}}
                            @can('crear productos')
                                <a href="{{ route('productos.create') }}" 
                                   class="btn btn-primary float-right" 
                                   title="Nuevo">
                                    <i class="fas fa-plus nav-icon"></i>
                                </a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <table id="example1" 
                                   class="table table-bordered table-hover" 
                                   style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">ID</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th width="60px">Estado</th>
                                        <th width="120px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->id }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->categoria->nombre }}</td>
                                        <td>${{ number_format($producto->precio, 2) }}</td>
                                        <td>{{ $producto->stock }}</td>
                                        <td>
                                            {{-- Cambio de estado: si lo consideras parte de "editar productos" --}}
                                            @can('editar productos')
                                                <input data-type="producto" 
                                                       data-id="{{ $producto->id }}" 
                                                       class="toggle-class" 
                                                       type="checkbox"
                                                       data-onstyle="success" 
                                                       data-offstyle="danger"
                                                       data-toggle="toggle" 
                                                       data-on="Activo" 
                                                       data-off="Inactivo"
                                                       {{ $producto->estado ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
                                            {{-- Ver detalle: permiso "mostrar productos" --}}
                                            @can('mostrar productos')
                                                <a href="{{ route('productos.show', $producto->id) }}" 
                                                   class="btn btn-secondary btn-sm" 
                                                   title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan

                                            {{-- Editar: permiso "editar productos" --}}
                                            @can('editar productos')
                                                <a href="{{ route('productos.edit', $producto->id) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan

                                            {{-- Eliminar (si lo incluiste en "editar productos" o si tienes un permiso "eliminar productos") --}}
                                            @can('editar productos')
                                                <form class="d-inline delete-form" 
                                                      action="{{ route('productos.destroy', $producto) }}" 
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm" 
                                                            title="Eliminar"
                                                            onclick="return confirm('¿Seguro de eliminar este producto?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
