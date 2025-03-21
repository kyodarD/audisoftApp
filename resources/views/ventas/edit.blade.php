@extends('layouts.app')

@section('title', 'Editar Venta')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Editar Venta</h1>
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3 class="card-title">Editar Venta</h3>
                        </div>
                        <form method="POST" action="{{ route('ventas.update', $venta->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <!-- Cliente -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cliente_id">Cliente <strong class="text-danger">*</strong></label>
                                            <select class="form-control @error('cliente_id') is-invalid @enderror" name="cliente_id" required>
                                                <option value="" disabled>Seleccione un cliente</option>
                                                @foreach($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>
                                                        {{ $cliente->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('cliente_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Fecha de Venta -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="fecha_venta">Fecha de Venta <strong class="text-danger">*</strong></label>
                                            <input type="date" name="fecha_venta" class="form-control @error('fecha_venta') is-invalid @enderror" value="{{ old('fecha_venta', $venta->fecha_venta) }}" required>
                                            @error('fecha_venta')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Estado de la Venta y Descuento de la Venta al lado -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="estado_venta">Estado de la Venta</label>
                                            <select name="estado_venta" class="form-control @error('estado_venta') is-invalid @enderror">
                                                <option value="pendiente" {{ $venta->estado_venta == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="pagado" {{ $venta->estado_venta == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                            </select>
                                            @error('estado_venta')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="descuento_venta">Descuento de la Venta (en %)</label>
                                            <input type="number" name="descuento_venta" class="form-control @error('descuento_venta') is-invalid @enderror" value="{{ old('descuento_venta', $venta->descuento_venta) }}" min="0" max="100">
                                            @error('descuento_venta')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Producto -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="producto_id">Producto <strong class="text-danger">*</strong></label>
                                            <select class="form-control @error('producto_id') is-invalid @enderror" name="producto_id" required>
                                                <option value="" disabled>Seleccione un producto</option>
                                                @foreach($productos as $producto)
                                                    <option value="{{ $producto->id }}" {{ $venta->producto_id == $producto->id ? 'selected' : '' }}>
                                                        {{ $producto->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('producto_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Cantidad del Producto -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cantidad_producto">Cantidad <strong class="text-danger">*</strong></label>
                                            <input type="number" name="cantidad_producto" class="form-control @error('cantidad_producto') is-invalid @enderror" value="{{ old('cantidad_producto', $venta->cantidad_producto) }}" required min="1">
                                            @error('cantidad_producto')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Precio Unitario -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="precio_unitario_producto">Precio Unitario <strong class="text-danger">*</strong></label>
                                            <input type="number" name="precio_unitario_producto" class="form-control @error('precio_unitario_producto') is-invalid @enderror" value="{{ old('precio_unitario_producto', $venta->precio_unitario_producto) }}" required min="0" step="0.01">
                                            @error('precio_unitario_producto')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="subtotal">Subtotal <strong class="text-danger">*</strong></label>
                                            <input type="number" name="subtotal" class="form-control @error('subtotal') is-invalid @enderror" value="{{ old('subtotal', $venta->subtotal) }}" required min="0" step="0.01">
                                            @error('subtotal')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Total de la Venta (ocupa toda la fila) -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="total_venta">Total de la Venta <strong class="text-danger">*</strong></label>
                                            <input type="number" name="total_venta" class="form-control @error('total_venta') is-invalid @enderror" value="{{ old('total_venta', $venta->total_venta) }}" step="0.01" required>
                                            @error('total_venta')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Campo Oculto: Registrado Por -->
                                    <input type="hidden" name="registradopor" value="{{ Auth::user()->id }}">
                                </div>
                            </div>

                            <div class="card-footer d-flex">
                                <button type="submit" class="btn btn-success">Actualizar Venta</button>
                                <a href="{{ route('ventas.index') }}" class="btn btn-danger ml-2">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
