@extends('layouts.app')

@section('title', 'Crear Nuevo Empleado')

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
                            <form action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Campo oculto registradopor -->
                                <input type="hidden" name="registradopor" value="{{ auth()->id() }}">

                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Usuario -->
                                        <div class="form-group">
                                            <label for="user_id">Usuario</label>
                                            <select name="user_id" id="user_id" class="form-control" required>
                                                <option value="">Seleccione un usuario</option>
                                                @foreach($users as $usuario)
                                                    <option value="{{ $usuario->id }}"
                                                        data-nombre="{{ $usuario->name }}"
                                                        data-email="{{ $usuario->email }}"
                                                        data-role="{{ $usuario->roles->first()->name ?? '' }}"
                                                        {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                                        {{ $usuario->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nombre -->
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control"
                                                   value="{{ old('nombre') }}" required readonly>
                                            @error('nombre')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                   value="{{ old('email') }}" required readonly>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Cédula -->
                                        <div class="form-group">
                                            <label for="cedula">Cédula</label>
                                            <input type="text" name="cedula" id="cedula" class="form-control"
                                                   value="{{ old('cedula') }}" required maxlength="20">
                                            @error('cedula')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Teléfono -->
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" name="telefono" id="telefono" class="form-control"
                                                   value="{{ old('telefono') }}" required>
                                            @error('telefono')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Dirección -->
                                        <div class="form-group">
                                            <label for="direccion">Dirección</label>
                                            <input type="text" name="direccion" id="direccion" class="form-control"
                                                   value="{{ old('direccion') }}">
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
                                                   value="{{ old('cargo') }}" required>
                                            @error('cargo')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Salario -->
                                        <div class="form-group">
                                            <label for="salario">Salario</label>
                                            <input type="number" name="salario" id="salario" class="form-control"
                                                   value="{{ old('salario') }}" required step="0.01" min="0">
                                            @error('salario')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Estado -->
                                        <div class="form-group">
                                            <label for="estado">Estado</label>
                                            <select name="estado" id="estado" class="form-control" required>
                                                <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                                <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
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
                                                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- País -->
                                        <div class="form-group">
                                            <label for="pais_id">País</label>
                                            <select name="pais_id" id="pais_id" class="form-control" required>
                                                <option value="">Seleccione un país</option>
                                                @foreach($paises as $pais)
                                                    <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                                                @endforeach
                                            </select>
                                            @error('pais_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Departamento -->
                                        <div class="form-group">
                                            <label for="departamento_id">Departamento</label>
                                            <select name="departamento_id" id="departamento_id" class="form-control" required>
                                                <option value="">Seleccione un departamento</option>
                                            </select>
                                            @error('departamento_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Ciudad -->
                                        <div class="form-group">
                                            <label for="ciudad_id">Ciudad</label>
                                            <select name="ciudad_id" id="ciudad_id" class="form-control" required>
                                                <option value="">Seleccione una ciudad</option>
                                            </select>
                                            @error('ciudad_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Foto -->
                                        <div class="form-group">
                                            <label for="photo">Foto</label>
                                            <input type="file" name="photo" id="photo" class="form-control-file">
                                            @error('photo')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary ml-2">Guardar</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Scripts para autocompletar y dependientes -->
<script>
document.getElementById("user_id").addEventListener("change", function () {
    let selectedUser = this.options[this.selectedIndex];

    document.getElementById("nombre").value = selectedUser.getAttribute("data-nombre") || "";
    document.getElementById("email").value = selectedUser.getAttribute("data-email") || "";

    let roleName = selectedUser.getAttribute("data-role");
    let roleSelect = document.getElementById("role_id");

    if (roleName) {
        for (let i = 0; i < roleSelect.options.length; i++) {
            if (roleSelect.options[i].text === roleName) {
                roleSelect.selectedIndex = i;
                break;
            }
        }
    } else {
        roleSelect.selectedIndex = 0;
    }
});

// Dropdowns dependientes
const paisesData = @json($paises);
const paisSelect = document.getElementById('pais_id');
const departamentoSelect = document.getElementById('departamento_id');
const ciudadSelect = document.getElementById('ciudad_id');

paisSelect.addEventListener('change', function () {
    const paisId = parseInt(this.value);
    const pais = paisesData.find(p => p.id === paisId);

    departamentoSelect.innerHTML = '<option value="">Seleccione un departamento</option>';
    ciudadSelect.innerHTML = '<option value="">Seleccione una ciudad</option>';

    if (pais) {
        pais.departamentos.forEach(dep => {
            const option = document.createElement('option');
            option.value = dep.id;
            option.text = dep.nombre;
            departamentoSelect.appendChild(option);
        });
    }
});

departamentoSelect.addEventListener('change', function () {
    const paisId = parseInt(paisSelect.value);
    const depId = parseInt(this.value);

    ciudadSelect.innerHTML = '<option value="">Seleccione una ciudad</option>';

    const pais = paisesData.find(p => p.id === paisId);
    if (!pais) return;

    const departamento = pais.departamentos.find(d => d.id === depId);
    if (departamento) {
        departamento.ciudads.forEach(ciudad => {
            const option = document.createElement('option');
            option.value = ciudad.id;
            option.text = ciudad.nombre;
            ciudadSelect.appendChild(option);
        });
    }
});
</script>
@endsection
