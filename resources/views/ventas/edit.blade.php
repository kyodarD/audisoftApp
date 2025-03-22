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
            <form method="POST" action="{{ route('ventas.update', $venta->id) }}">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Actualizar Venta</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Cliente -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cliente <strong class="text-danger">*</strong></label>
                                    <select name="cliente_id" class="form-control" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Fecha -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Venta</label>
                                    <input type="date" name="fecha_venta" class="form-control" value="{{ $venta->fecha_venta->format('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de productos -->
                        <div class="form-group">
                            <label>Productos</label>
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
                                <tbody>
                                    @foreach($venta->detalles as $i => $detalle)
                                        <tr>
                                            <td>
                                                <select name="detalles[{{ $i }}][producto_id]" class="form-control producto-select" required>
                                                    <option value="">Seleccione</option>
                                                    @foreach($productos as $producto)
                                                        <option value="{{ $producto->id }}"
                                                            data-stock="{{ $producto->stock }}"
                                                            data-precio="{{ $producto->precio }}"
                                                            {{ $detalle->producto_id == $producto->id ? 'selected' : '' }}>
                                                            {{ $producto->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control stock" readonly value="{{ $detalle->producto->stock }}"></td>
                                            <td><input type="number" name="detalles[{{ $i }}][cantidad]" class="form-control cantidad" value="{{ $detalle->cantidad }}" min="1" required></td>
                                            <td><input type="number" name="detalles[{{ $i }}][precio_unitario]" class="form-control precio" value="{{ $detalle->precio_unitario }}" readonly></td>
                                            <td><input type="number" name="detalles[{{ $i }}][subtotal]" class="form-control subtotal" value="{{ $detalle->subtotal }}" readonly></td>
                                            <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Descuento -->
                        <div class="form-group">
                            <label>Descuento (%)</label>
                            <input type="number" name="descuento_venta" class="form-control" value="{{ $venta->descuento_venta ?? 0 }}" min="0" max="100">
                        </div>

                        <!-- Total -->
                        <div class="form-group">
                            <label>Total de la Venta <strong class="text-danger">*</strong></label>
                            <input type="number" name="total_venta" class="form-control" readonly value="{{ $venta->total_venta }}" step="0.01" required>
                        </div>

                        <!-- Estado -->
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado_venta" class="form-control">
                                <option value="pendiente" {{ $venta->estado_venta == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="pagado" {{ $venta->estado_venta == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                <option value="cancelado" {{ $venta->estado_venta == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <input type="hidden" name="estado" value="activo">
                            <input type="hidden" name="registradopor" value="{{ Auth::id() }}">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
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
    let index = {{ $venta->detalles->count() }};

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
