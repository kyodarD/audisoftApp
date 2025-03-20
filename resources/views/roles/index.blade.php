@extends('layouts.app')

@section('title','Listado De Roles')

@section('content')

<div class="content-wrapper">
    <section class="content-header" style="text-align: right;">
		<div class="container-fluid">
		</div>
    </section>
	@include('layouts.partial.msg')
    <section class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header bg-secondary" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
							@yield('title')
							@can('roles.create')
								<a href="{{ route('roles.create') }}" class="btn btn-primary float-right" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
							@endcan
						</div>
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped" style="width:100%">
								<thead class="text-primary">
									<tr>
										<th width="10px">Id</th>
										<th>Rol</th>
										<th width="30px">Acción</th>
									</tr>
								</thead>
								<tbody>
									@foreach($roles as $rol)
									<tr>
										<td>{{ $rol->id }}</td>
										<td>{{ $rol->name }}</td>
										<td>
										@can('roles.edit')
											<a href="{{ route('roles.edit',$rol) }}" class="btn btn-info btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
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