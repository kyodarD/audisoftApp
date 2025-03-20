@extends('layouts.app')

@section('title', 'Listado de Permisos')

@section('content')

<div class="content-wrapper">
    <section class="content-header" style="text-align: right;">
        <div class="container-fluid"></div>
    </section>
    @include('layouts.partial.msg')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3>@yield('title')</h3>
                            @can('permissions.create')
                                <a href="{{ route('permissions.create') }}" class="btn btn-primary float-right" title="Nuevo">
                                    <i class="fas fa-plus nav-icon"></i>
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Guard</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                        <td>
                                            @can('permissions.edit')
                                                <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-info btn-sm" title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            @can('permissions.destroy')
                                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"
                                                        onclick="return confirm('¿Seguro que quieres eliminar este permiso?')">
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
