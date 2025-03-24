@extends('layouts.app')

@section('title', 'Editar Empleado')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white" style="font-size: 1.5rem; font-weight: 500;">
                            @yield('title')
                        </div>
                        <div class="card-body">
                            <form action="{{ route('empleados.update', $empleado->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Usuario (readonly) -->
                                        <div class="form-group">
                                            <label for="user_id">Usuario</label>
                                            <select class="form-control" disabled>
                                                <option value="{{ $empleado->user->id }}">{{ $empleado->user->name }}</option>
                                            </select>
                                        </div>

                                        <!-- Nombre -->
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control"
                                                   value="{{ old('nombre', $empleado->nombre) }}" required>
                                            @error('nombre')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                   value="{{ old('email', $empleado->email) }}" required>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Cédula -->
                                        <div class="form-group">
                                            <label for="cedula">Cédula</label>
                                            <input type="text" name="cedula" id="cedula" class="form-control"
                                                   value="{{ old('cedula', $empleado->cedula) }}" required maxlength="20">
                                            @error('cedula')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Teléfono -->
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" name="telefono" id="telefono" class="form-control"
                                                   value="{{ old('telefono', $empleado->telefono) }}" required>
                                            @error('telefono')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Dirección -->
                                        <div class="form-group">
                                            <label for="direccion">Dirección</label>
                                            <input type="text" name="direccion" id="direccion" class="form-control"
                                                   value="{{ old('direccion', $empleado->direccion) }}">
                                            @error('direccion')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Cargo -->
                                        <div class="form-group">
                                            <label for="cargo">Cargo</label>
                                            <input type="text" name="cargo" id="cargo" class="form-control"
                                                   value="{{ old('cargo', $empleado->cargo) }}" required>
                                            @error('cargo')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Salario -->
                                        <div class="form-group">
                                            <label for="salario">Salario</label>
                                            <input type="number" name="salario" id="salario" class="form-control"
                                                   value="{{ old('salario', $empleado->salario) }}" required step="0.01" min="0">
                                            @error('salario')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Estado -->
                                        <div class="form-group">
                                            <label for="estado">Estado</label>
                                            <select name="estado" id="estado" class="form-control" required>
                                                <option value="activo" {{ old('estado', $empleado->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                                <option value="inactivo" {{ old('estado', $empleado->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('estado')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Rol -->
                                        <div class="form-group">
                                            <label for="role_id">Rol</label>
                                            <select name="role_id" id="role_id" class="form-control" required>
                                                <option value="">Seleccione un rol</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role_id', $empleado->role_id) == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Ciudad -->
                                        <div class="form-group">
                                            <label for="ciudad_id">Ciudad</label>
                                            <select name="ciudad_id" id="ciudad_id" class="form-control" required>
                                                <option value="">Seleccione una ciudad</option>
                                                @foreach($ciudades as $ciudad)
                                                    <option value="{{ $ciudad->id }}"
                                                        data-departamento="{{ $ciudad->departamento->nombre ?? '' }}"
                                                        data-pais="{{ $ciudad->departamento->pais->nombre ?? '' }}"
                                                        {{ old('ciudad_id', $empleado->ciudad_id) == $ciudad->id ? 'selected' : '' }}>
                                                        {{ $ciudad->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('ciudad_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Departamento (readonly) -->
                                        <div class="form-group">
                                            <label for="departamento">Departamento</label>
                                            <input type="text" id="departamento" class="form-control" readonly
                                                value="{{ $empleado->ciudad->departamento->nombre ?? '' }}">
                                        </div>

                                        <!-- País (readonly) -->
                                        <div class="form-group">
                                            <label for="pais">País</label>
                                            <input type="text" id="pais" class="form-control" readonly
                                                value="{{ $empleado->ciudad->departamento->pais->nombre ?? '' }}">
                                        </div>

                                        <!-- Foto -->
                                        <div class="form-group">
                                            <label for="photo">Foto (opcional)</label>
                                            <input type="file" name="photo" id="photo" class="form-control-file">
                                            @error('photo')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            @if ($empleado->photo)
                                                <div class="mt-2">
                                                    <strong>Foto actual:</strong><br>
                                                    <img src="{{ asset('storage/' . $empleado->photo) }}" alt="Foto" width="100">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary ml-2">Actualizar</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Script para actualizar departamento y país al cambiar la ciudad -->
<script>
document.getElementById("ciudad_id").addEventListener("change", function () {
    let selected = this.options[this.selectedIndex];
    document.getElementById("departamento").value = selected.getAttribute("data-departamento") || "";
    document.getElementById("pais").value = selected.getAttribute("data-pais") || "";
});
</script>

@endsection
