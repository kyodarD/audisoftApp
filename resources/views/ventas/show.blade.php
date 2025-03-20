@extends('layouts.app')

@section('title', 'Detalle de Venta')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Detalle de Venta</h1>
        </div>
    </section>

    @include('layouts.partial.msg') <!-- Mostrar mensajes de éxito o error -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3 class="card-title">Venta #{{ $venta->id }} - {{ $venta->cliente->nombre }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <p><strong>Fecha de Venta:</strong> {{ $venta->fecha_venta }}</p>
                                    <p><strong>Total Venta:</strong> {{ $venta->total_venta }}</p>
                                    <p><strong>Estado de la Venta:</strong> {{ $venta->estado_venta }}</p>
                                    <p><strong>Descuento:</strong> {{ $venta->descuento_venta }} %</p>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <h4>Detalles de Productos</h4>
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
                                            @foreach($venta->detalleventa as $detalle)
                                            <tr>
                                                <td>{{ $detalle->producto->nombre }}</td>
                                                <td>{{ $detalle->cantidad_producto }}</td>
                                                <td>{{ $detalle->precio_unitario_producto }}</td>
                                                <td>{{ $detalle->subtotal }}</td>
                                            </tr>
                                            @endforeach
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
