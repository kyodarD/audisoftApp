@extends('layouts.app')
@section('title', 'Listado De Compras')
@section('content')
<div class="content-wrapper">
    <section class="content-header" style="text-align: right;">
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
                            @can('compras.create')
                                <a href="{{ route('compras.create') }}" class="btn btn-primary float-right" title="Nueva Compra">
                                    <i class="fas fa-plus nav-icon"></i>
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">ID</th>
                                        <th>Cliente</th>
                                        <th>Total Compra</th>
                                        <th>Fecha de Compra</th>
                                        <th width="60px">Estado</th>
                                        <th width="90px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($compras as $compra)
                                    <tr>
                                        <td>{{ $compra->id }}</td>
                                        <td>{{ $compra->cliente->nombre }}</td>
                                        <td>{{ $compra->total_compra }}</td> <!-- Debe existir el campo total_compra -->
                                        <td>{{ $compra->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @can('compras.cambioestado')
                                                <input data-type="compras" data-id="{{ $compra->id }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" 
                                                data-toggle="toggle" data-on="Activo" data-off="Inactivo" {{ $compra->estado ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
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