
@extends('layouts.app')

@section('title', 'Registrar Compra')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Registrar Compra</h1>
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('compras.store') }}">
                @csrf
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Nueva Compra</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Proveedor -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="proveedor_id">Proveedor <strong class="text-danger">*</strong></label>
                                    <select class="form-control @error('proveedor_id') is-invalid @enderror" name="proveedor_id" required>
                                        <option value="" disabled selected>Seleccione un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de Compra -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_compra">Fecha de Compra <strong class="text-danger">*</strong></label>
                                    <input type="date" name="fecha_compra" class="form-control @error('fecha_compra') is-invalid @enderror" value="{{ old('fecha_compra') }}" required>
                                    @error('fecha_compra')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de productos -->
                        <div class="form-group">
                            <label>Productos <strong class="text-danger">*</strong></label>
                            <table class="table table-bordered" id="tabla-productos">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                        <th><button type="button" class="btn btn-success btn-sm" id="addProducto">+</button></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Descuento -->
                        <div class="form-group">
                            <label for="descuento_compra">Descuento (%)</label>
                            <input type="number" name="descuento_compra" class="form-control" value="0" min="0" max="100">
                        </div>

                        <!-- Total -->
                        <div class="form-group">
                            <label for="total_compra">Total de la Compra <strong class="text-danger">*</strong></label>
                            <input type="number" name="total_compra" class="form-control" readonly required step="0.01">
                        </div>

                        <!-- Estado -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado_compra">Estado de la Compra</label>
                                    <select name="estado_compra" class="form-control">
                                        <option value="pendiente">Pendiente</option>
                                        <option value="pagado">Pagado</option>
                                        <option value="cancelado">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="estado" value="activo">
                            <input type="hidden" name="registradopor" value="{{ Auth::id() }}">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar Compra</button>
                        <a href="{{ route('compras.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const productos = @json($productos);
    let index = 0;

    function actualizarTotales() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(el => {
            total += parseFloat(el.value || 0);
        });

        const descuento = parseFloat(document.querySelector('input[name="descuento_compra"]').value || 0);
        const totalConDescuento = total - (total * descuento / 100);
        document.querySelector('input[name="total_compra"]').value = totalConDescuento.toFixed(2);
    }

    function crearFilaProducto() {
        const row = document.createElement('tr');
        const options = productos.map(p =>
            `<option value="${p.id}" data-precio="${p.precio}">${p.nombre}</option>`
        ).join('');

        row.innerHTML = `
            <td>
                <select name="detalles[${index}][producto_id]" class="form-control producto-select" required>
                    <option value="">Seleccione</option>
                    ${options}
                </select>
            </td>
            <td><input type="number" name="detalles[${index}][cantidad]" class="form-control cantidad" min="1" required></td>
            <td><input type="number" name="detalles[${index}][precio_unitario]" class="form-control precio" readonly></td>
            <td><input type="number" name="detalles[${index}][subtotal]" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
        `;
        document.querySelector('#tabla-productos tbody').appendChild(row);
        index++;
    }

    document.getElementById('addProducto').addEventListener('click', crearFilaProducto);

    document.addEventListener('change', function (e) {
        if (e.target.matches('.producto-select')) {
            const row = e.target.closest('tr');
            const selected = e.target.selectedOptions[0];
            const precio = selected.dataset.precio;

            row.querySelector('.precio').value = precio;
            row.querySelector('.cantidad').value = 1;
            row.querySelector('.subtotal').value = precio;
            actualizarTotales();
        }

        if (e.target.matches('.cantidad')) {
            const row = e.target.closest('tr');
            const cantidad = parseInt(e.target.value || 0);
            const precio = parseFloat(row.querySelector('.precio').value || 0);

            const subtotal = cantidad * precio;
            row.querySelector('.subtotal').value = subtotal.toFixed(2);
            actualizarTotales();
        }

        if (e.target.name === 'descuento_compra') {
            actualizarTotales();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.matches('.remove-row')) {
            e.target.closest('tr').remove();
            actualizarTotales();
        }
    });
</script>
@endpush
