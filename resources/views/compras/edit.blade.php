@extends('layouts.app')

@section('title', 'Editar Compra')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Editar Compra</h1>
        </div>
    </section>
    
    @include('layouts.partial.msg') <!-- Incluir mensajes de éxito o error -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h4 class="m-0">Detalles de la Compra</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('compras.update', $compra->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="cliente_id">Cliente</label>
                                    <select class="form-control" name="cliente_id" id="cliente_id" required>
                                        <option value="">Seleccione un Cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ $compra->cliente_id == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="total_compra">Total de la Compra</label>
                                    <input type="text" class="form-control" name="total_compra" id="total_compra" value="{{ $compra->total_compra }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_compra">Fecha de la Compra</label>
                                    <input type="date" class="form-control" name="fecha_compra" id="fecha_compra" value="{{ $compra->fecha_compra->format('Y-m-d') }}" required>
                                </div>

                                <h5>Productos</h5>
                                <div id="productos-container">
                                    @foreach ($compra->productos as $index => $producto)
                                        <div class="product-row">
                                            <div class="form-group">
                                                <label for="productos[{{ $index }}][id]">Producto</label>
                                                <select class="form-control" name="productos[{{ $index }}][id]" required>
                                                    <option value="">Seleccione un Producto</option>
                                                    @foreach ($productos as $prod)
                                                        <option value="{{ $prod->id }}" {{ $producto->id == $prod->id ? 'selected' : '' }}>
                                                            {{ $prod->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="productos[{{ $index }}][cantidad]">Cantidad</label>
                                                <input type="number" class="form-control" name="productos[{{ $index }}][cantidad]" value="{{ $producto->pivot->cantidad }}" required min="1">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-secondary" id="add-product">Agregar otro producto</button>
                                <br><br>
                                <button type="submit" class="btn btn-success">Actualizar Compra</button>
                                <a href="{{ route('compras.index') }}" class="btn btn-danger">Cancelar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    let productIndex = {{ count($compra->productos) }};
    document.getElementById('add-product').addEventListener('click', function() {
        const container = document.getElementById('productos-container');
        const newRow = document.createElement('div');
        newRow.className = "product-row";
        newRow.innerHTML = `
            <div class="form-group">
                <label for="productos[${productIndex}][id]">Producto</label>
                <select class="form-control" name="productos[${productIndex}][id]" required>
                    <option value="">Seleccione un Producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="productos[${productIndex}][cantidad]">Cantidad</label>
                <input type="number" class="form-control" name="productos[${productIndex}][cantidad]" required min="1">
            </div>
        `;
        container.appendChild(newRow);
        productIndex++;
    });
</script>
@endsection