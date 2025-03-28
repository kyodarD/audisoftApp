@extends('layouts.app')

@section('title', 'Listado De Clientes')

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

                            {{-- Botón "Crear Cliente": permiso "crear clientes" --}}
                            @can('crear clientes')
                                <a href="{{ route('clientes.create') }}"
                                   class="btn btn-primary float-right"
                                   title="Nuevo Cliente">
                                    <i class="fas fa-plus nav-icon"></i>
                                </a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                        <th width="60px">Estado</th>
                                        <th width="90px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->id }}</td>
                                        <td>{{ $cliente->nombre }}</td>
                                        <td>{{ $cliente->email }}</td>
                                        <td>{{ $cliente->telefono }}</td>
                                        <td>{{ $cliente->direccion }}</td>
                                        <td>
                                            {{-- Cambio de estado: usar "editar clientes" o un permiso específico --}}
                                            @can('editar clientes')
                                                <input data-type="cliente"
                                                       data-id="{{ $cliente->id }}"
                                                       class="toggle-class"
                                                       type="checkbox"
                                                       data-onstyle="success"
                                                       data-offstyle="danger"
                                                       data-toggle="toggle"
                                                       data-on="Activo"
                                                       data-off="Inactivo"
                                                       {{ $cliente->estado == 'activo' ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
                                            {{-- Editar cliente --}}
                                            @can('editar clientes')
                                                <a href="{{ route('clientes.edit', $cliente->id) }}"
                                                   class="btn btn-info btn-sm"
                                                   title="Editar Cliente">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan

                                            {{-- Eliminar cliente (si lo consideras parte de "editar clientes" o tienes un permiso "eliminar clientes") --}}
                                            @can('editar clientes')
                                                <form class="d-inline delete-form"
                                                      action="{{ route('clientes.destroy', $cliente->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Eliminar Cliente"
                                                            onclick="return confirm('¿Seguro de eliminar este cliente?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- card-body -->
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
