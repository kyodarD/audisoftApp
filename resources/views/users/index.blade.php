@extends('layouts.app')

@section('title','Listado De Usuarios')

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
                        <div class="card-header bg-secondary" style="font-size: 1.75rem;font-weight: 500;">
                            @yield('title')

                            {{-- Botón "Crear Usuario", protegido por "crear usuarios" --}}
                            @can('crear usuarios')
                                <a href="{{ route('users.create') }}" class="btn btn-primary float-right" title="Nuevo Usuario">
                                    <i class="fas fa-plus nav-icon"></i>
                                </a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">ID</th>
                                        <th>Usuario</th>
                                        <th>Correo</th>
                                        <th>Fotografía</th>
                                        <th>Rol</th>
                                        <th width="60px">Estado</th>
                                        <th width="100px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            @if ($user->photo)
                                                @php
                                                    $filename = basename($user->photo);
                                                @endphp
                                                <img src="{{ route('imagen.usuario', $filename) }}"
                                                    alt="Foto de {{ $user->name }}"
                                                    title="{{ $user->name }}"
                                                    class="img-thumbnail"
                                                    style="height: 70px; width: 70px; object-fit: cover;"
                                                    onerror="this.onerror=null;this.src='https://via.placeholder.com/70?text=No+Img';">
                                                <br>
                                                <small class="text-muted d-block" style="max-width: 150px; overflow-wrap: break-word;">
                                                    {{ $filename }}
                                                </small>
                                            @else
                                                <span class="badge badge-secondary">Sin Foto</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->getRoleNames()->isNotEmpty())
                                                @foreach($user->getRoleNames() as $rolNombre)
                                                    <span class="badge badge-success">{{ $rolNombre }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge badge-secondary">Sin Rol</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('editar usuarios')
                                                <input type="checkbox"
                                                    class="toggle-class"
                                                    data-id="{{ $user->id }}"
                                                    data-type="user"
                                                    data-toggle="toggle"
                                                    data-on="Activo"
                                                    data-off="Inactivo"
                                                    data-onstyle="success"
                                                    data-offstyle="danger"
                                                    {{ $user->estado ? 'checked' : '' }}
                                                    style="height: 30px; width: 60px; text-align: center;">
                                            @endcan
                                        </td>
                                        <td>
                                            @can('editar usuarios')
                                                <a href="{{ route('users.edit', $user) }}"
                                                    class="btn btn-info btn-sm" title="Editar Usuario">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
