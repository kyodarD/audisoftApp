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

                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Selección de Usuario -->
                                        <div class="form-group">
                                            <label for="user_id">Usuario</label>
                                            <select name="user_id" id="user_id" class="form-control" required>
                                                <option value="">Seleccione un usuario</option>
                                                @foreach($usuarios as $usuario)
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

                                        <!-- Nombre (Autocompletado) -->
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" 
                                                   value="{{ old('nombre') }}" required readonly>
                                            @error('nombre') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Email (Autocompletado) -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" 
                                                   value="{{ old('email') }}" required readonly>
                                            @error('email') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Cédula (Ingreso manual) -->
                                        <div class="form-group">
                                            <label for="cedula">Cédula</label>
                                            <input type="text" name="cedula" id="cedula" class="form-control" 
                                                   value="{{ old('cedula') }}" required maxlength="20">
                                            @error('cedula') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Teléfono (Ingreso manual) -->
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" name="telefono" id="telefono" class="form-control" 
                                                   value="{{ old('telefono') }}" required>
                                            @error('telefono') 
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
                                                   value="{{ old('salario') }}" required step="0.01" min="0" max="9999999999.99">
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

                                        <!-- Rol (Autocompletado) -->
                                        <div class="form-group">
                                            <label for="role_id">Rol</label>
                                            <select name="role_id" id="role_id" class="form-control" required>
                                                <option value="">Seleccione un rol</option>
                                                @foreach($roles as $id => $name)
                                                    <option value="{{ $id }}" 
                                                        {{ old('role_id') == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role_id') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Carga de Imagen (Ingreso manual) -->
                                        <div class="form-group">
                                            <label for="image">Foto</label>
                                            <input type="file" name="image" id="image" class="form-control-file">
                                            @error('image') 
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

<!-- Script para autocompletar datos del usuario -->
<script>
document.getElementById("user_id").addEventListener("change", function () {
    let selectedUser = this.options[this.selectedIndex];

    document.getElementById("nombre").value = selectedUser.getAttribute("data-nombre") || "";
    document.getElementById("email").value = selectedUser.getAttribute("data-email") || "";

    // Asignar automáticamente el rol basado en el usuario seleccionado
    let roleSelect = document.getElementById("role_id");
    let roleName = selectedUser.getAttribute("data-role");

    if (roleName) {
        for (let i = 0; i < roleSelect.options.length; i++) {
            if (roleSelect.options[i].text === roleName) {
                roleSelect.selectedIndex = i;
                break;
            }
        }
    } else {
        roleSelect.selectedIndex = 0; // Selecciona la primera opción por defecto si no hay rol
    }
});
</script>

@endsection
