@extends('layouts.app')

@section('title', 'Listado De Empleados')

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
                        <div class="card-header bg-secondary" style="font-size: 1.75rem; font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                            @can('empleados.create')
                                <a href="{{ route('empleados.create') }}" class="btn btn-primary float-right" title="Nuevo Empleado">
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
                                        <th>Cédula</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Cargo</th>
                                        <th>Salario</th>
                                        <th>Estado</th>
                                        <th width="150px">Acción</th> <!-- Se amplió el ancho para acomodar los botones -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($empleados as $empleado)
                                    <tr>
                                        <td>{{ $empleado->id }}</td>
                                        <td>{{ $empleado->nombre }}</td>
                                        <td>{{ $empleado->cedula }}</td>
                                        <td>{{ $empleado->email }}</td>
                                        <td>{{ $empleado->telefono }}</td>
                                        <td>{{ $empleado->cargo }}</td>
                                        <td>{{ number_format($empleado->salario, 2) }}</td>
                                        <td>
                                            @can('empleados.cambioestadoempleado')
                                                <input data-type="empleado" data-id="{{ $empleado->id }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" 
                                                data-toggle="toggle" data-on="Activo" data-off="Inactivo" {{ $empleado->estado == 'activo' ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
                                            <!-- Botón "Ver Detalles" -->
                                            @can('empleados.show')
                                                <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-primary btn-sm" title="Ver Detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan
                                            
                                            <!-- Botón "Editar" -->
                                            @can('empleados.edit')
                                                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-info btn-sm" title="Editar Empleado">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            
                                            <!-- Botón "Eliminar" -->
                                            @can('empleados.destroy')
                                                <form class="d-inline delete-form" action="{{ route('empleados.destroy', $empleado->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar Empleado">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
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
