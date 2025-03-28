@extends('layouts.app')

@section('title','Listado De Categorias')

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
                        <div class="card-header bg-secondary"
                             style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')

                            {{-- Botón CREAR CATEGORÍA: permiso "crear categorias" --}}
                            @can('crear categorias')
                                <a href="{{ route('categorias.create') }}"
                                   class="btn btn-primary float-right"
                                   title="Nuevo">
                                    <i class="fas fa-plus nav-icon"></i>
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <table id="example1"
                                   class="table table-bordered table-hover"
                                   style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">ID</th>
                                        <th>Categoría</th>
                                        <th>Descripción</th>
                                        <th width="60px">Estado</th>
                                        <th width="90px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categorias as $categoria)
                                        <tr>
                                            <td>{{ $categoria->id }}</td>
                                            <td>{{ $categoria->nombre }}</td>
                                            <td>{{ $categoria->descripcion }}</td>
                                            <td>
                                                {{-- Cambio de estado. Si lo incluyes en "editar categorias" --}}
                                                @can('editar categorias')
                                                    <input data-type="categoria"
                                                           data-id="{{ $categoria->id }}"
                                                           class="toggle-class"
                                                           type="checkbox"
                                                           data-onstyle="success"
                                                           data-offstyle="danger"
                                                           data-toggle="toggle"
                                                           data-on="Activo"
                                                           data-off="Inactivo"
                                                           {{ $categoria->estado ? 'checked' : '' }}>
                                                @endcan
                                            </td>
                                            <td>
                                                {{-- Editar categoría: "editar categorias" --}}
                                                @can('editar categorias')
                                                    <a href="{{ route('categorias.edit', $categoria->id) }}"
                                                       class="btn btn-info btn-sm"
                                                       title="Editar">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                @endcan

                                                {{-- Eliminar categoría: si también lo metiste en "editar categorias"
                                                     o si usas un permiso más específico "eliminar categorias" --}}
                                                @can('editar categorias')
                                                    <form class="d-inline delete-form"
                                                          action="{{ route('categorias.destroy', $categoria->id) }}"
                                                          method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm"
                                                                title="Eliminar"
                                                                onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- card-body -->
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
