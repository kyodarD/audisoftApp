@extends('layouts.app')

@section('title', 'Editar Usuario y Asignar Roles')

@section('content')

<div class="content-wrapper">
    <section class="content-header" style="text-align: right;">
        <div class="container-fluid"></div>
    </section>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3>@yield('title')</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Nombre -->
                                <div class="form-group">
                                    <label for="name">Nombre del Usuario</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Correo -->
                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Contraseña -->
                                <div class="form-group">
                                    <label for="password">Contraseña (Dejar en blanco si no deseas cambiar)</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Rol -->
                                <hr>
                                <h4>Asignar Rol</h4>
                                <div class="form-group">
                                    <label for="role_id">Rol</label>
                                    <select name="roles[]" id="role_id" class="form-control @error('roles') is-invalid @enderror" required>
                                        <option value="">Seleccione un rol</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Foto -->
                                <div class="form-group">
                                    <label for="photo">Fotografía</label>
                                    <input type="file" name="photo"
                                           class="form-control-file @error('photo') is-invalid @enderror">
                                    @error('photo')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @if ($user->photo)
                                        <img src="{{ Storage::url($user->photo) }}" alt="Foto de {{ $user->name }}" class="img-thumbnail" style="height: 70px; width: 70px; object-fit: cover;">
                                    @else
                                        <span class="badge badge-secondary">Sin Foto</span>
                                    @endif
                                </div>

                                <!-- Estado oculto (siempre activo) -->
                                <input type="hidden" name="estado" value="1">

                                <!-- Botones -->
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-2 col-xs-4">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Actualizar</button>
                                        </div>
                                        <div class="col-lg-2 col-xs-4">
                                            <a href="{{ route('users.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
