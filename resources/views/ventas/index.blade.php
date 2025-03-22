@extends('layouts.app')

@section('title', 'Listado de Ventas')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header bg-secondary" style="font-size: 1.75rem; font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                            <div class="float-right">
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
                                        <th>Estado</th>
                                        <th>Estado Registro</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $venta->cliente->nombre ?? 'Sin cliente' }}</td>
                                        <td>${{ number_format($venta->total_venta, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($venta->estado_venta == 'pagado')
                                                <span class="badge badge-success">Pagado</span>
                                            @elseif($venta->estado_venta == 'pendiente')
                                                <span class="badge badge-warning text-white">Pendiente</span>
                                            @elseif($venta->estado_venta == 'cancelado')
                                                <span class="badge badge-danger">Cancelado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('ventas.cambioestadoventa')
                                                <input data-type="ventas" data-id="{{ $venta->id }}" class="toggle-class" type="checkbox"
                                                    data-onstyle="success" data-offstyle="danger" 
                                                    data-toggle="toggle" data-on="Activo" data-off="Inactivo"
                                                    {{ $venta->estado == 'activo' ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
                                            <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-success btn-sm" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('ventas.edit')
                                                <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-info btn-sm" title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            @can('ventas.destroy')
                                                <form class="d-inline delete-form" action="{{ route('ventas.destroy', $venta->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
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
