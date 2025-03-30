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

                                <!-- Campo oculto para estado (siempre activo) -->
                                <input type="hidden" name="estado" value="activo">

                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Usuario (no editable) -->
                                        <div class="form-group">
                                            <label for="user_id">Usuario</label>
                                            <input type="text" class="form-control" value="{{ $empleado->user->name }}" readonly>
                                        </div>

                                        <!-- Nombre (readonly) -->
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" class="form-control" value="{{ $empleado->nombre }}" readonly>
                                        </div>

                                        <!-- Email (readonly) -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" value="{{ $empleado->email }}" readonly>
                                        </div>

                                        <!-- Cédula (readonly) -->
                                        <div class="form-group">
                                            <label for="cedula">Cédula</label>
                                            <input type="text" class="form-control" value="{{ $empleado->cedula }}" readonly>
                                        </div>

                                        <!-- Teléfono -->
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" name="telefono" id="telefono" class="form-control"
                                                   value="{{ old('telefono', $empleado->telefono) }}" required>
                                            @error('telefono') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Dirección -->
                                        <div class="form-group">
                                            <label for="direccion">Dirección</label>
                                            <input type="text" name="direccion" id="direccion" class="form-control"
                                                   value="{{ old('direccion', $empleado->direccion) }}">
                                            @error('direccion') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Cargo -->
                                        <div class="form-group">
                                            <label for="cargo">Cargo</label>
                                            <input type="text" name="cargo" id="cargo" class="form-control"
                                                   value="{{ old('cargo', $empleado->cargo) }}" required>
                                            @error('cargo') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Salario -->
                                        <div class="form-group">
                                            <label for="salario">Salario</label>
                                            <input type="number" name="salario" id="salario" class="form-control"
                                                   value="{{ old('salario', $empleado->salario) }}" required step="0.01" min="0">
                                            @error('salario') <div class="text-danger">{{ $message }}</div> @enderror
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
                                            @error('role_id') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- País -->
                                        <div class="form-group">
                                            <label for="pais_id">País</label>
                                            <select name="pais_id" id="pais_id" class="form-control" required>
                                                <option value="">Seleccione un país</option>
                                                @foreach($paises as $pais)
                                                    <option value="{{ $pais->id }}"
                                                        {{ old('pais_id', $empleado->pais_id) == $pais->id ? 'selected' : '' }}>
                                                        {{ $pais->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('pais_id') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Departamento -->
                                        <div class="form-group">
                                            <label for="departamento_id">Departamento</label>
                                            <select name="departamento_id" id="departamento_id" class="form-control" required>
                                                <option value="">Seleccione un departamento</option>
                                            </select>
                                            @error('departamento_id') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Ciudad -->
                                        <div class="form-group">
                                            <label for="ciudad_id">Ciudad</label>
                                            <select name="ciudad_id" id="ciudad_id" class="form-control" required>
                                                <option value="">Seleccione una ciudad</option>
                                            </select>
                                            @error('ciudad_id') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Foto -->
                                        <div class="form-group">
                                            <label for="photo">Foto</label>
                                            <input type="file" name="photo" id="photo" class="form-control-file">
                                            @if($empleado->photo)
                                                <p class="mt-2">Foto actual: <a href="{{ asset('storage/' . $empleado->photo) }}" target="_blank">Ver</a></p>
                                            @endif
                                            @error('photo') <div class="text-danger">{{ $message }}</div> @enderror
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

<script>
const paisesData = @json($paises);

function cargarDepartamentos(paisId, selected = null) {
    const pais = paisesData.find(p => p.id == paisId);
    const depSelect = document.getElementById('departamento_id');
    depSelect.innerHTML = '<option value="">Seleccione un departamento</option>';

    if (pais) {
        pais.departamentos.forEach(dep => {
            const option = document.createElement('option');
            option.value = dep.id;
            option.text = dep.nombre;
            if (selected && selected == dep.id) option.selected = true;
            depSelect.appendChild(option);
        });
    }
}

function cargarCiudades(paisId, departamentoId, selected = null) {
    const pais = paisesData.find(p => p.id == paisId);
    const departamento = pais ? pais.departamentos.find(d => d.id == departamentoId) : null;
    const ciudadSelect = document.getElementById('ciudad_id');
    ciudadSelect.innerHTML = '<option value="">Seleccione una ciudad</option>';

    if (departamento) {
        departamento.ciudads.forEach(ciudad => {
            const option = document.createElement('option');
            option.value = ciudad.id;
            option.text = ciudad.nombre;
            if (selected && selected == ciudad.id) option.selected = true;
            ciudadSelect.appendChild(option);
        });
    }
}

// Inicialización
cargarDepartamentos({{ old('pais_id', $empleado->pais_id) }}, {{ old('departamento_id', $empleado->departamento_id) }});
cargarCiudades({{ old('pais_id', $empleado->pais_id) }}, {{ old('departamento_id', $empleado->departamento_id) }}, {{ old('ciudad_id', $empleado->ciudad_id) }});

document.getElementById('pais_id').addEventListener('change', function () {
    cargarDepartamentos(this.value);
    document.getElementById('ciudad_id').innerHTML = '<option value="">Seleccione una ciudad</option>';
});

document.getElementById('departamento_id').addEventListener('change', function () {
    cargarCiudades(document.getElementById('pais_id').value, this.value);
});
</script>
@endsection
