@extends('layouts.app')

@section('title', 'Editar Proveedor')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@yield('title')</h1>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3 class="card-title">Editar información del proveedor</h3>
                        </div>
                        
                        <form method="POST" action="{{ route('proveedores.update', $proveedor->id) }}" id="formEditarProveedor">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <!-- Nombre -->
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('nombre') is-invalid @enderror" 
                                                   id="nombre"
                                                   name="nombre" 
                                                   value="{{ old('nombre', $proveedor->nombre) }}"
                                                   placeholder="Por ejemplo, Proveedor XYZ" 
                                                   required>
                                            @error('nombre')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Cédula y Email -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cedula">Cédula <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('cedula') is-invalid @enderror" 
                                                   id="cedula"
                                                   name="cedula" 
                                                   value="{{ old('cedula', $proveedor->cedula) }}"
                                                   placeholder="Por ejemplo, 1234567890" 
                                                   pattern="[0-9]*"
                                                   inputmode="numeric"
                                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                                   required>
                                            @error('cedula')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email"
                                                   name="email" 
                                                   value="{{ old('email', $proveedor->email) }}"
                                                   placeholder="correo@ejemplo.com">
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Teléfono y Dirección -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" 
                                                   class="form-control @error('telefono') is-invalid @enderror" 
                                                   id="telefono"
                                                   name="telefono" 
                                                   value="{{ old('telefono', $proveedor->telefono) }}"
                                                   placeholder="Por ejemplo, 123456789">
                                            @error('telefono')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="direccion">Dirección</label>
                                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                                      id="direccion"
                                                      name="direccion" 
                                                      rows="3"
                                                      placeholder="Ingrese la dirección del proveedor">{{ old('direccion', $proveedor->direccion) }}</textarea>
                                            @error('direccion')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Estado -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="estado">Estado <span class="text-danger">*</span></label>
                                            <select class="form-control @error('estado') is-invalid @enderror" 
                                                    id="estado"
                                                    name="estado" 
                                                    required>
                                                <option value="activo" {{ old('estado', $proveedor->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                                <option value="inactivo" {{ old('estado', $proveedor->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('estado')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="registradopor" value="{{ Auth::id() }}">
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 mb-2">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-save mr-2"></i>Actualizar
                                        </button>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 mb-2">
                                        <a href="{{ route('proveedores.index') }}" class="btn btn-danger btn-block">
                                            <i class="fas fa-arrow-left mr-2"></i>Atrás
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
// Prevenir doble envío del formulario
document.getElementById('formEditarProveedor').addEventListener('submit', function(e) {
    let submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Actualizando...';
});

// Validación para el campo de cédula
document.querySelector('input[name="cedula"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endpush
@endsection