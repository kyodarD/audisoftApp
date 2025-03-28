@extends('layouts.app')

@section('title', 'Editar Cliente')

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
                            <h3 class="card-title">Actualizar información del cliente</h3>
                        </div>
                        <form method="POST" action="{{ route('clientes.update', $cliente) }}" id="formEditarCliente">
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
                                                   value="{{ old('nombre', $cliente->nombre) }}"
                                                   placeholder="Por ejemplo, Cliente XYZ" 
                                                   required>
                                            @error('nombre')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Cédula -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cedula">Cédula <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('cedula') is-invalid @enderror" 
                                                   id="cedula"
                                                   name="cedula" 
                                                   value="{{ old('cedula', $cliente->cedula) }}"
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
                                                   value="{{ old('email', $cliente->email) }}"
                                                   placeholder="correo@ejemplo.com">
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" 
                                                   class="form-control @error('telefono') is-invalid @enderror" 
                                                   id="telefono"
                                                   name="telefono" 
                                                   value="{{ old('telefono', $cliente->telefono) }}"
                                                   placeholder="Ejemplo: 1234567890">
                                            @error('telefono')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="direccion">Dirección</label>
                                            <textarea name="direccion" 
                                                      class="form-control @error('direccion') is-invalid @enderror" 
                                                      id="direccion"
                                                      placeholder="Ingrese la dirección del cliente">{{ old('direccion', $cliente->direccion) }}</textarea>
                                            @error('direccion')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="estado">Estado <span class="text-danger">*</span></label>
                                            <select class="form-control @error('estado') is-invalid @enderror" 
                                                    id="estado"
                                                    name="estado" 
                                                    required>
                                                <option value="activo" {{ old('estado', $cliente->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                                <option value="inactivo" {{ old('estado', $cliente->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('estado')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div> -->
                                    <input type="hidden" name="estado" value="activo">

                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Actualizar</button>
                                    </div>
                                    <div class="col-lg-2 col-xs-4">
                                        <a href="{{ route('clientes.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
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
document.getElementById('formEditarCliente').addEventListener('submit', function(e) {
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