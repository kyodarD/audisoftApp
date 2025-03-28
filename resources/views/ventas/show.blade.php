@extends('layouts.app')

@section('title', 'Detalle de Venta')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Detalle de Venta</h1>
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header bg-secondary">
                            <h3 class="card-title">Venta #{{ $venta->id }} - {{ $venta->cliente->nombre ?? 'Sin cliente' }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Info de la venta -->
                                <div class="col-lg-6 col-sm-12">
                                    <p><strong>Fecha de Venta:</strong> {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</p>
                                    <p><strong>Total Venta:</strong> ${{ number_format($venta->total_venta, 2) }}</p>
                                    <p><strong>Descuento:</strong> {{ $venta->descuento_venta ?? 0 }} %</p>
                                    <p><strong>Estado de la Venta:</strong>
                                        @if($venta->estado_venta == 'pagado')
                                            <span class="badge badge-success">Pagado</span>
                                        @elseif($venta->estado_venta == 'pendiente')
                                            <span class="badge badge-warning">Pendiente</span>
                                        @else
                                            <span class="badge badge-danger">Cancelado</span>
                                        @endif
                                    </p>
                                </div>

                                <!-- Detalles de productos -->
                                <div class="col-lg-6 col-sm-12">
                                    <h4>Productos Vendidos</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unitario</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($venta->detalles as $detalle)
                                            <tr>
                                                <td>{{ $detalle->producto->nombre ?? 'N/A' }}</td>
                                                <td>{{ $detalle->cantidad }}</td>
                                                <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                                                <td>${{ number_format($detalle->subtotal, 2) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No hay productos en esta venta.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver al Listado</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
