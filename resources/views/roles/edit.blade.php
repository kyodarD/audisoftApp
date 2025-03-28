@extends('layouts.app')

@section('title', 'Editar Rol')

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

                        {{-- Título --}}
                        <div class="card-header bg-secondary">
                            <h3>@yield('title')</h3>
                        </div>

                        {{-- Formulario --}}
                        <div class="card-body">
                            <form method="POST" action="{{ route('roles.update', $role) }}">
                                @csrf
                                @method('PUT')

                                {{-- Nombre del Rol --}}
                                <div class="form-group">
                                    <label for="name">Nombre del Rol</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $role->name) }}"
                                           required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Descripción del Rol --}}
                                <div class="form-group">
                                    <label for="description">Descripción del Rol</label>
                                    <textarea name="description"
                                              id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="2">{{ old('description', $role->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Guard Name oculto --}}
                                <input type="hidden" name="guard_name" value="web">

                                <hr>

                                <h4 class="mb-3">Permisos por módulo</h4>

                                {{-- Botón "Seleccionar todo" global --}}
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="selectAllPermissions">
                                        <label class="custom-control-label font-weight-bold"
                                               for="selectAllPermissions">
                                            Seleccionar todos los permisos
                                        </label>
                                    </div>
                                </div>

                                {{-- Grid de Módulos --}}
                                <div class="row">
                                    @forelse($permissions as $modulo => $moduloPermissions)
                                        <div class="col-md-4 mb-2">
                                            <div class="border p-2" style="border-radius: 5px;">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="text-uppercase mb-0">
                                                        {{ ucfirst($modulo) }}
                                                    </strong>
                                                    {{-- "Seleccionar todo" por módulo --}}
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                               class="custom-control-input select-module"
                                                               id="selectAll_{{ $modulo }}"
                                                               data-module="{{ $modulo }}">
                                                        <label class="custom-control-label text-muted"
                                                               for="selectAll_{{ $modulo }}"
                                                               style="font-size: 0.85rem;">
                                                            Todo
                                                        </label>
                                                    </div>
                                                </div>

                                                {{-- Lista de permisos del módulo --}}
                                                <ul class="list-group list-group-flush" style="margin:0; padding:0;">
                                                    @foreach($moduloPermissions as $permission)
                                                        <li class="list-group-item px-1 py-1" style="border: none;">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox"
                                                                       class="custom-control-input perm-{{ $modulo }}"
                                                                       id="perm_{{ $permission->id }}"
                                                                       name="permissions[]"
                                                                       value="{{ $permission->name }}"
                                                                       {{-- Verificamos si el permiso ya está en el rol, o en old('permissions') --}}
                                                                       @if(in_array($permission->name, old('permissions', $rolePermissions ?? [])))
                                                                            checked
                                                                       @endif>
                                                                <label class="custom-control-label"
                                                                       for="perm_{{ $permission->id }}"
                                                                       style="font-size: 0.9rem;">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @empty
                                        <p>No hay permisos disponibles.</p>
                                    @endforelse
                                </div>
                                <!-- /row -->

                                @error('permissions')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                {{-- Botones --}}
                                <div class="card-footer mt-3">
                                    <div class="row">
                                        <div class="col-lg-2 col-xs-4">
                                            <button type="submit"
                                                    class="btn btn-primary btn-block btn-flat">
                                                Actualizar
                                            </button>
                                        </div>
                                        <div class="col-lg-2 col-xs-4">
                                            <a href="{{ route('roles.index') }}"
                                               class="btn btn-danger btn-block btn-flat">
                                                Atrás
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> 
                        {{-- /.card-body --}}
                    </div> 
                    {{-- /.card --}}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

{{-- JS extra para el "Seleccionar todo" --}}
@push('scripts')
<script>
    // Seleccionar / Deseleccionar TODOS los permisos globalmente
    document.getElementById('selectAllPermissions').addEventListener('change', function(e) {
        const checked = e.target.checked;
        // Seleccionar todos los checkboxes de permisos
        document.querySelectorAll('input[name="permissions[]"]').forEach(function(checkbox) {
            checkbox.checked = checked;
        });
        // Y todos los "seleccionar módulo" checkboxes
        document.querySelectorAll('.select-module').forEach(function(modCheck) {
            modCheck.checked = checked;
        });
    });

    // Seleccionar / Deseleccionar todos los permisos de un módulo
    document.querySelectorAll('.select-module').forEach(function(moduleCheckbox) {
        moduleCheckbox.addEventListener('change', function(e) {
            const moduleName = e.target.dataset.module;
            const checked = e.target.checked;
            document.querySelectorAll('.perm-' + moduleName).forEach(function(permCheckbox) {
                permCheckbox.checked = checked;
            });
            // Si algún módulo se desmarca, quitamos el check global
            if (!checked) {
                document.getElementById('selectAllPermissions').checked = false;
            }
        });
    });

    // Si se desmarca un permiso individual, desmarcamos el global
    document.querySelectorAll('input[name="permissions[]"]').forEach(function(permCheckbox) {
        permCheckbox.addEventListener('change', function() {
            if (!permCheckbox.checked) {
                // Quitamos check global
                document.getElementById('selectAllPermissions').checked = false;
            }
        });
    });
</script>
@endpush
