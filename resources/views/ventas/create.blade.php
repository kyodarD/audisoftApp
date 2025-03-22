@extends('layouts.app')

@section('title', 'Crear Venta')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Crear Venta</h1>
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('ventas.store') }}">
                @csrf
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Registrar Nueva Venta</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Cliente -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cliente_id">Cliente <strong class="text-danger">*</strong></label>
                                    <select class="form-control @error('cliente_id') is-invalid @enderror" name="cliente_id" required>
                                        <option value="" disabled selected>Seleccione un cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de Venta -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_venta">Fecha de Venta <strong class="text-danger">*</strong></label>
                                    <input type="date" name="fecha_venta" class="form-control @error('fecha_venta') is-invalid @enderror" value="{{ old('fecha_venta') }}" required>
                                    @error('fecha_venta')
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
                                        <th>Stock</th>
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
                            <label for="descuento_venta">Descuento (%)</label>
                            <input type="number" name="descuento_venta" class="form-control" value="0" min="0" max="100">
                        </div>

                        <!-- Total -->
                        <div class="form-group">
                            <label for="total_venta">Total de la Venta <strong class="text-danger">*</strong></label>
                            <input type="number" name="total_venta" class="form-control" readonly required step="0.01">
                        </div>

                        <!-- Estado de la venta -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado_venta">Estado de la Venta</label>
                                    <select name="estado_venta" class="form-control">
                                        <option value="pendiente">Pendiente</option>
                                        <option value="pagado">Pagado</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="estado" value="activo">
                            <!-- <input type="hidden" name="registradopor" value="{{ auth()->id() }}"> -->
                            <input type="hidden" name="registradopor" value="{{ Auth::id() }}">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar Venta</button>
                        <a href="{{ route('ventas.index') }}" class="btn btn-danger">Cancelar</a>
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

        const descuento = parseFloat(document.querySelector('input[name="descuento_venta"]').value || 0);
        const totalConDescuento = total - (total * descuento / 100);
        document.querySelector('input[name="total_venta"]').value = totalConDescuento.toFixed(2);
    }

    function crearFilaProducto() {
        const row = document.createElement('tr');
        const options = productos.map(p =>
            `<option value="${p.id}" data-stock="${p.stock}" data-precio="${p.precio}">${p.nombre}</option>`
        ).join('');

        row.innerHTML = `
            <td>
                <select name="detalles[${index}][producto_id]" class="form-control producto-select" required>
                    <option value="">Seleccione</option>
                    ${options}
                </select>
            </td>
            <td><input type="text" class="form-control stock" readonly></td>
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
            const stock = selected.dataset.stock;
            const precio = selected.dataset.precio;

            row.querySelector('.stock').value = stock;
            row.querySelector('.precio').value = precio;
            row.querySelector('.cantidad').value = 1;
            row.querySelector('.subtotal').value = precio;
            actualizarTotales();
        }

        if (e.target.matches('.cantidad')) {
            const row = e.target.closest('tr');
            const cantidad = parseInt(e.target.value || 0);
            const stock = parseInt(row.querySelector('.stock').value || 0);
            const precio = parseFloat(row.querySelector('.precio').value || 0);

            if (cantidad > stock) {
                alert('La cantidad no puede superar el stock disponible.');
                e.target.value = stock;
                return;
            }

            const subtotal = cantidad * precio;
            row.querySelector('.subtotal').value = subtotal.toFixed(2);
            actualizarTotales();
        }

        if (e.target.name === 'descuento_venta') {
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
