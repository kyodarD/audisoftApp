@extends('layouts.app')

@section('title', 'Editar Compra')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Editar Compra</h1>
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('compras.update', $compra->id) }}">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Actualizar Compra</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Proveedor -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Proveedor <strong class="text-danger">*</strong></label>
                                    <select name="proveedor_id" class="form-control" required>
                                        <option value="">Seleccione un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" {{ $compra->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Fecha -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Compra</label>
                                    <input type="date" name="fecha_compra" class="form-control" value="{{ $compra->fecha_compra->format('Y-m-d') }}" required>
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
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                        <th><button type="button" class="btn btn-success btn-sm" id="addProducto">+</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($compra->detalles as $i => $detalle)
                                        <tr>
                                            <td>
                                                <select name="detalles[{{ $i }}][producto_id]" class="form-control producto-select" required>
                                                    <option value="">Seleccione</option>
                                                    @foreach($productos as $producto)
                                                        <option value="{{ $producto->id }}"
                                                            data-precio="{{ $producto->precio }}"
                                                            {{ $detalle->producto_id == $producto->id ? 'selected' : '' }}>
                                                            {{ $producto->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
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
                            <input type="number" name="descuento_compra" class="form-control" value="{{ $compra->descuento_compra ?? 0 }}" min="0" max="100">
                        </div>

                        <!-- Total -->
                        <div class="form-group">
                            <label>Total de la Compra <strong class="text-danger">*</strong></label>
                            <input type="number" name="total_compra" class="form-control" readonly value="{{ $compra->total_compra }}" step="0.01" required>
                        </div>

                        <!-- Estado -->
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado_compra" class="form-control">
                                <option value="pendiente" {{ $compra->estado_compra == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="pagado" {{ $compra->estado_compra == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                <option value="cancelado" {{ $compra->estado_compra == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <input type="hidden" name="estado" value="activo">
                            <input type="hidden" name="registradopor" value="{{ Auth::id() }}">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Actualizar Compra</button>
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
    let index = {{ $compra->detalles->count() }};

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
