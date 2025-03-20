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
                        <div class="card-header bg-secondary" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                            @can('users.create')
                                <a href="{{ route('users.create') }}" class="btn btn-primary float-right" title="Nuevo">
                                    <i class="fas fa-plus nav-icon"></i>
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">Id</th>
                                        <th>Usuario</th>
                                        <th>Correo</th>
                                        <th>Fotografía</th>
                                        <th>Rol</th>
                                        <th width="60px">Estado</th>
                                        <th width="30px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <center>
                                                @if ($user->photo)
                                                    <img class="img-responsive img-thumbnail" 
                                                         src="{{ Storage::url($user->photo) }}" 
                                                         style="height: 70px; width: 70px" 
                                                         alt="Foto de {{ $user->name }}">
                                                @else
                                                    <span class="badge badge-secondary">Sin Foto</span>
                                                @endif
                                            </center>
                                        </td>
                                        <td>
                                            @if($user->getRoleNames()->isNotEmpty())
                                                @foreach($user->getRoleNames() as $rolNombre)                                       
                                                    <h5><span class="badge badge-success">{{ $rolNombre }}</span></h5>
                                                @endforeach
                                            @else
                                                <h5><span class="badge badge-secondary">Sin Rol</span></h5>
                                            @endif
                                        </td>
                                        <td>
                                            @can('users.cambioestadouser')
                                                <input data-type="user" data-id="{{ $user->id }}" class="toggle-class" 
                                                       type="checkbox" data-onstyle="success" data-offstyle="danger" 
                                                       data-toggle="toggle" data-on="Activo" data-off="Inactivo" 
                                                       {{ $user->estado ? 'checked' : '' }}>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('users.edit')
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-info btn-sm" title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
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
