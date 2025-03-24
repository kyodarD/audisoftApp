@extends('layouts.app')

@section('title', 'Detalle del Empleado')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h4 class="mb-0">@yield('title')</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Columna izquierda -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Usuario:</strong>
                                        <p>{{ $empleado->user->name ?? 'N/A' }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Nombre:</strong>
                                        <p>{{ $empleado->nombre }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        <p>{{ $empleado->email }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Cédula:</strong>
                                        <p>{{ $empleado->cedula }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Teléfono:</strong>
                                        <p>{{ $empleado->telefono }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Dirección:</strong>
                                        <p>{{ $empleado->direccion ?? 'No especificada' }}</p>
                                    </div>
                                </div>

                                <!-- Columna derecha -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Cargo:</strong>
                                        <p>{{ $empleado->cargo }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Salario:</strong>
                                        <p>${{ number_format($empleado->salario, 2) }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Estado:</strong>
                                        <p>{{ ucfirst($empleado->estado) }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Rol:</strong>
                                        <p>{{ $empleado->role->name ?? 'No asignado' }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Ciudad:</strong>
                                        <p>{{ $empleado->ciudad->nombre ?? 'N/A' }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Departamento:</strong>
                                        <p>{{ $empleado->ciudad->departamento->nombre ?? 'N/A' }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>País:</strong>
                                        <p>{{ $empleado->ciudad->departamento->pais->nombre ?? 'N/A' }}</p>
                                    </div>

                                    <div class="form-group">
                                        <strong>Registrado por:</strong>
                                        <p>{{ $empleado->registradoPor->name ?? 'N/A' }}</p>
                                    </div>

                                    @if($empleado->photo)
                                        <div class="form-group">
                                            <strong>Foto:</strong><br>
                                            <img src="{{ asset('storage/' . $empleado->photo) }}" alt="Foto del empleado" width="150">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mt-4 text-right">
                                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Volver</a>
                                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-primary">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
