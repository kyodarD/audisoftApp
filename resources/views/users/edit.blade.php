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

                                <input type="hidden" name="id" value="{{ $user->id }}">

                                <div class="form-group">
                                    <label for="name">Nombre del Usuario</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <hr>
                                <h3>Lista de Roles</h3>
                                <div class="form-group">
                                    <ul class="list-unstyled">
                                        @foreach($roles as $role)
                                            <li>
                                                <label>
                                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                                    {{ $role->name }}
                                                </label>
                                            </li>    
                                        @endforeach
                                    </ul>
                                    @error('roles')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label for="photo">Fotografía</label>
                                            <input type="file" class="form-control-file @error('photo') is-invalid @enderror" name="photo" id="photo">
                                            @error('photo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <select name="estado" class="form-control @error('estado') is-invalid @enderror" required>
                                        <option value="1" {{ old('estado', $user->estado) == '1' ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('estado', $user->estado) == '0' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
