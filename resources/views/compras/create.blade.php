@extends('layouts.app')

@section('title', 'Crear Nueva Compra')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Crear Nueva Compra</h1>
        </div>
    </section>

    @include('layouts.partial.msg') <!-- Mostrar mensajes de éxito o error -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h4 class="m-0">Detalles de la Compra</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('compras.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="cliente_id">Cliente</label>
                                    <select class="form-control" name="cliente_id" id="cliente_id" required>
                                        <option value="">Seleccione un Cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="total_compra">Total de la Compra</label>
                                    <input type="text" class="form-control" name="total_compra" id="total_compra" placeholder="Ingrese el total" required>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_compra">Fecha de la Compra</label>
                                    <input type="date" class="form-control" name="fecha_compra" id="fecha_compra" required>
                                </div>

                                <h5>Productos</h5>
                                <div id="productos-container">
                                    <div class="product-row">
                                        <div class="form-group">
                                            <label for="productos[0][id]">Producto</label>
                                            <select class="form-control" name="productos[0][id]" required>
                                                <option value="">Seleccione un Producto</option>
                                                @foreach($productos as $producto)
                                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="productos[0][cantidad]">Cantidad</label>
                                            <input type="number" class="form-control" name="productos[0][cantidad]" required min="1">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" id="add-product">Agregar otro producto</button>
                                <br><br>
                                <button type="submit" class="btn btn-success">Guardar Compra</button>
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
    let productIndex = 1;
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