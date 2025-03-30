@extends('layouts.app')

@section('title', 'Detalle de Producto')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Detalle de Producto</h1>
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header bg-secondary">
                            <h3 class="card-title">Producto #{{ $producto->id }} - {{ $producto->nombre }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Información del producto -->
                                <div class="col-lg-6 col-sm-12">
                                    <p><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
                                    <p><strong>Proveedor:</strong> {{ $producto->proveedor->nombre ?? 'Sin proveedor' }}</p>
                                    <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                                    <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                                    <p><strong>Stock Disponible:</strong> {{ $producto->stock }}</p>
                                    <p><strong>Fecha de Vencimiento:</strong> {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') }}</p>
                                    <p><strong>Estado:</strong>
                                        @if($producto->estado)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-danger">Inactivo</span>
                                        @endif
                                    </p>
                                </div>

                                <!-- Imagen del producto desde S3 -->
                                <div class="col-lg-6 col-sm-12 text-center">
                                    <h4>Imagen del Producto</h4>
                                    @if($producto->img)
                                        @php
                                            // Genera la URL de la imagen desde S3 usando el controlador
                                            $filename = basename($producto->img); // Obtiene el nombre del archivo
                                            $imgUrl = route('imagen.producto', $filename); // Ruta para obtener la imagen
                                        @endphp
                                        <img src="{{ $imgUrl }}" 
                                             alt="Imagen del producto" 
                                             class="img-fluid rounded" 
                                             style="max-height: 300px;"
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/300x300?text=No+Img';">
                                    @else
                                        <p class="text-muted">No hay imagen disponible.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver al Listado</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
