@extends('layouts.app')

@section('title', 'Listado de Compras')

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
                                @can('compras.create')
                                <a href="{{ route('compras.create') }}" class="btn btn-primary" title="Nueva Compra">
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
                                        <th>Proveedor</th>
                                        <th>Total Compra</th>
                                        <th>Fecha de Compra</th>
                                        <th>Estado</th>
                                        <th>Estado Registro</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($compras as $compra)
                                    <tr>
                                        <td>{{ $compra->id }}</td>
                                        <td>{{ $compra->proveedor->nombre ?? 'Sin proveedor' }}</td>
                                        <td>${{ number_format($compra->total_compra, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($compra->estado_compra == 'pagado')
                                                <span class="badge badge-success">Pagado</span>
                                            @elseif($compra->estado_compra == 'pendiente')
                                                <span class="badge badge-warning text-white">Pendiente</span>
                                            @elseif($compra->estado_compra == 'cancelado')
                                                <span class="badge badge-danger">Cancelado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('compras.cambioestadocompra')
                                                <input data-type="compras" data-id="{{ $compra->id }}" class="toggle-class" type="checkbox"
                                                    data-onstyle="success" data-offstyle="danger" 
                                                    data-toggle="toggle" data-on="Activo" data-off="Inactivo"
                                                    {{ $compra->estado == 'activo' ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
                                            <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-success btn-sm" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('compras.edit')
                                                <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-info btn-sm" title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            @can('compras.destroy')
                                                <form class="d-inline delete-form" action="{{ route('compras.destroy', $compra->id) }}" method="POST">
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
