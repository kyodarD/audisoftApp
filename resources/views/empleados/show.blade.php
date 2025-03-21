@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalles del Empleado</h1>
                </div>
                <div class="col-sm-6 text-right"></div>
            </div>
        </div>
    </section>
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Sección que abarca todo el ancho -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h3 class="card-title">Información del Empleado</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Columna izquierda con detalles -->
                                <div class="col-md-6">
                                    <table class="table table-striped">
                                        <tr><th>ID:</th><td>{{ $empleado->id }}</td></tr>
                                        <tr><th>Nombre:</th><td>{{ $empleado->nombre }}</td></tr>
                                        <tr><th>Cédula:</th><td>{{ $empleado->cedula }}</td></tr>
                                        <tr><th>Teléfono:</th><td>{{ $empleado->telefono }}</td></tr>
                                        <tr><th>Email:</th><td>{{ $empleado->email }}</td></tr>
                                        <tr><th>Dirección:</th><td>{{ $empleado->direccion }}</td></tr>
                                        <tr><th>Cargo:</th><td>{{ $empleado->cargo }}</td></tr>
                                        <tr><th>Salario:</th><td>${{ number_format($empleado->salario, 2) }}</td></tr>
                                    </table>
                                </div>

                                <!-- Columna derecha con estado y rol -->
                                <div class="col-md-6">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Estado:</th>
                                            <td>
                                                <span class="badge {{ $empleado->estado == 'activo' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ ucfirst($empleado->estado) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Rol:</th>
                                            <td>
                                                <span class="badge badge-info">{{ $empleado->usuario->roles->first()->name ?? 'Sin rol asignado' }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Footer con botones -->
                        <div class="card-footer text-right">
                            <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            @can('empleados.edit')
                                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
