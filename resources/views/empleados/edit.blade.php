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
                                        <!-- Usuario (No editable, solo informativo) -->
                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <input type="text" class="form-control" value="{{ $empleado->usuario->name }}" readonly>
                                        </div>

                                        <!-- Nombre (Autocompletado, pero editable) -->
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" 
                                                   value="{{ old('nombre', $empleado->nombre) }}" required>
                                            @error('nombre') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Email (No editable) -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" value="{{ $empleado->usuario->email }}" readonly>
                                        </div>

                                        <!-- Cédula (Editable) -->
                                        <div class="form-group">
                                            <label for="cedula">Cédula</label>
                                            <input type="text" name="cedula" id="cedula" class="form-control" 
                                                   value="{{ old('cedula', $empleado->cedula) }}" required maxlength="20">
                                            @error('cedula') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Teléfono (Editable) -->
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" name="telefono" id="telefono" class="form-control" 
                                                   value="{{ old('telefono', $empleado->telefono) }}" required>
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
                                                   value="{{ old('cargo', $empleado->cargo) }}" required>
                                            @error('cargo') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Salario -->
                                        <div class="form-group">
                                            <label for="salario">Salario</label>
                                            <input type="number" name="salario" id="salario" class="form-control"
                                                   value="{{ old('salario', $empleado->salario) }}" required step="0.01" min="0" max="9999999999.99">
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
                                                @foreach($roles as $id => $name)
                                                    <option value="{{ $id }}" {{ old('role_id', $empleado->usuario->roles->first()->id ?? '') == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role_id') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Imagen (Opcional) -->
                                        <div class="form-group">
                                            <label for="image">Foto (Opcional)</label>
                                            <input type="file" name="image" id="image" class="form-control-file">
                                            @error('image') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Mostrar imagen actual si existe -->
                                        @if($empleado->photo)
                                            <div class="form-group">
                                                <label>Imagen Actual</label><br>
                                                <img src="{{ asset('storage/' . $empleado->photo) }}" class="img-thumbnail" width="150">
                                            </div>
                                        @endif
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

@endsection
