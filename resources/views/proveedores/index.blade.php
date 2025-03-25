@extends('layouts.app')

@section('title', 'Listado De Proveedores')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
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
                             style="font-size: 1.75rem; font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">

                            @yield('title')

                            {{-- Botón "Crear Proveedor": usar permiso "crear proveedores" --}}
                            @can('crear proveedores')
                                <a href="{{ route('proveedores.create') }}" 
                                   class="btn btn-primary float-right" 
                                   title="Nuevo Proveedor">
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
                                        <th>Cédula</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                        <th width="60px">Estado</th>
                                        <th width="90px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proveedores as $proveedor)
                                    <tr>
                                        <td>{{ $proveedor->id }}</td>
                                        <td>{{ $proveedor->nombre }}</td>
                                        <td>{{ $proveedor->cedula }}</td>
                                        <td>{{ $proveedor->email }}</td>
                                        <td>{{ $proveedor->telefono }}</td>
                                        <td>{{ $proveedor->direccion }}</td>
                                        <td>
                                            {{-- Cambio de estado: si lo agrupas en "editar proveedores" --}}
                                            @can('editar proveedores')
                                                <input data-type="proveedor" 
                                                       data-id="{{ $proveedor->id }}"
                                                       class="toggle-class" 
                                                       type="checkbox"
                                                       data-onstyle="success" 
                                                       data-offstyle="danger" 
                                                       data-toggle="toggle" 
                                                       data-on="Activo" 
                                                       data-off="Inactivo"
                                                       {{ $proveedor->estado == 'activo' ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
                                            {{-- Editar proveedor --}}
                                            @can('editar proveedores')
                                                <a href="{{ route('proveedores.edit', $proveedor->id) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Editar Proveedor">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan

                                            {{-- Eliminar proveedor (si lo agruparon con "editar proveedores",
                                                 o si tienes un permiso distinto "eliminar proveedores", ajusta) --}}
                                            @can('editar proveedores')
                                                <form class="d-inline delete-form" 
                                                      action="{{ route('proveedores.destroy', $proveedor->id) }}" 
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm" 
                                                            title="Eliminar Proveedor"
                                                            onclick="return confirm('¿Seguro de eliminar este proveedor?')">
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
