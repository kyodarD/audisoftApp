@extends('layouts.app')

@section('title', 'Listado de Ventas')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>

    @include('layouts.partial.msg') <!-- Mostrar mensajes de éxito o error -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        
                        <div class="card-header bg-secondary" style="font-size: 1.75rem; font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                            <div class="float-right">
                                @can('detalleventas.index')
                                <a href="{{ route('detallesventas.index') }}" class="btn btn-info mr-2" title="Ver Detalles de Venta">
                                    <i class="fas fa-list"></i>
                                </a>
                                @endcan
                                @can('ventas.create')
                                <a href="{{ route('ventas.create') }}" class="btn btn-primary" title="Nueva Venta">
                                    <i class="fas fa-plus nav-icon"></i>
                                </a>
                                 @endcan
                             </div>
                        </div>
                        
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">ID</th>
                                        <th>Cliente</th>
                                        <th>Total Venta</th>
                                        <th>Fecha de Venta</th>
                                        <th>Estado de la Venta</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $venta->cliente->nombre }}</td>
                                        <td>{{ $venta->total_venta }}</td>
                                        <td>{{ $venta->fecha_venta }}</td>
                                        <td>{{ $venta->estado_venta }}</td>
                                        <td>
                                            <!-- Cambio de estado -->
                                            @can('ventas.cambioestadoventa')
                                                <input data-type="ventas" data-id="{{ $venta->id }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" 
                                                data-toggle="toggle" data-on="Activo" data-off="Inactivo" {{ $venta->estado == 'activo' ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
                                            <!-- Ver detalles de la venta -->
                                            <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-success btn-sm" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Editar venta -->
                                            @can('ventas.edit')
                                                <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-info btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            <!-- Eliminar venta -->
                                            @can('ventas.destroy')
                                                <form class="d-inline delete-form" action="{{ route('ventas.destroy', $venta->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
