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
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h4 class="mb-0">@yield('title')</h4>
                        </div>

                        <div class="card-body">

                            <!-- Información Personal -->
                            <h6 class="text-primary border-bottom pb-1 mb-2">Información Personal</h6>
                            <div class="row py-2">
                                <div class="col-md-4 mb-2"><strong>Usuario:</strong> {{ $empleado->user->name ?? 'N/A' }}</div>
                                <div class="col-md-4 mb-2"><strong>Nombre:</strong> {{ $empleado->nombre }}</div>
                                <div class="col-md-4 mb-2"><strong>Email:</strong> {{ $empleado->email }}</div>
                                <div class="col-md-4 mb-2"><strong>Cédula:</strong> {{ $empleado->cedula }}</div>
                                <div class="col-md-4 mb-2"><strong>Teléfono:</strong> {{ $empleado->telefono }}</div>
                                <div class="col-md-4 mb-2"><strong>Dirección:</strong> {{ $empleado->direccion ?? 'No especificada' }}</div>
                            </div>

                            <!-- Información Laboral -->
                            <h6 class="text-primary border-bottom pb-1 mt-3 mb-2">Información Laboral</h6>
                            <div class="row py-2">
                                <div class="col-md-4 mb-2"><strong>Cargo:</strong> {{ $empleado->cargo }}</div>
                                <div class="col-md-4 mb-2"><strong>Salario:</strong> ${{ number_format($empleado->salario, 2) }}</div>
                                <div class="col-md-4 mb-2">
                                    <strong>Estado:</strong>
                                    @if($empleado->estado === 'activo')
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-2">
                                    <strong>Rol:</strong>
                                    @if($empleado->role)
                                        <span class="badge badge-primary">{{ $empleado->role->name }}</span>
                                    @else
                                        <span class="badge badge-secondary">No asignado</span>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-2"><strong>Registrado por:</strong> {{ $empleado->registradoPor->name ?? 'N/A' }}</div>
                            </div>

                            <!-- Ubicación -->
                            <h6 class="text-primary border-bottom pb-1 mt-3 mb-2">Ubicación</h6>
                            <div class="row py-2">
                                <div class="col-md-4 mb-2"><strong>Ciudad:</strong> {{ $empleado->ciudad->nombre ?? 'N/A' }}</div>
                                <div class="col-md-4 mb-2"><strong>Departamento:</strong> {{ $empleado->ciudad->departamento->nombre ?? 'N/A' }}</div>
                                <div class="col-md-4 mb-2"><strong>País:</strong> {{ $empleado->ciudad->departamento->pais->nombre ?? 'N/A' }}</div>
                            </div>

                            <!-- Foto -->
                            @if($empleado->photo)
                                <h6 class="text-primary border-bottom pb-1 mt-3 mb-2">Foto</h6>
                                <div class="row">
                                    <div class="col-md-3 mt-2">
                                        <img src="{{ asset('storage/' . $empleado->photo) }}" alt="Foto del empleado"
                                             class="img-thumbnail shadow-sm rounded" style="max-width: 100%;">
                                    </div>
                                </div>
                            @endif

                            <!-- Botones -->
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('empleados.index') }}" class="btn btn-secondary mr-2">Volver</a>
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
