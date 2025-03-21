@extends('layouts.app')

@section('title', 'Crear Rol')

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
                            <form method="POST" action="{{ route('roles.store') }}">
                                @csrf

                                <!-- Nombre del Rol -->
                                <div class="form-group">
                                    <label for="name">Nombre del Rol</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Descripción del Rol -->
                                <div class="form-group">
                                    <label for="description">Descripción del Rol</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <hr>
                                <h3>Lista de Permisos</h3>

                                <!-- Lista de Permisos -->
                                <div class="form-group">
                                    <ul class="list-unstyled">
                                        @foreach($permissions as $permission)
                                            <li>
                                                <label>
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                    {{ $permission->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @error('permissions')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <input type="hidden" name="guard_name" value="web">

                                <!-- Botones -->
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-2 col-xs-4">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
                                        </div>
                                        <div class="col-lg-2 col-xs-4">
                                            <a href="{{ route('roles.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
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
