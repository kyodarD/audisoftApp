@extends('layouts.app')

@section('title','Panel De Control')

@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">@yield('title')</h1>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				{{-- Total Clientes --}}
				<div class="col-lg-3 col-6">
					<div class="small-box bg-info">
						<div class="inner">
							<h3>{{ $clientesCount }}</h3>
							<p>Total Clientes</p>
						</div>
						<div class="icon">
							<i class="fas fa-users"></i>
						</div>
						<a href="{{ route('clientes.index') }}" class="small-box-footer">
							Más Información <i class="fas fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

				{{-- Total Proveedores --}}
				<div class="col-lg-3 col-6">
					<div class="small-box bg-success">
						<div class="inner">
							<h3>{{ $proveedoresCount }}</h3>
							<p>Total Proveedores</p>
						</div>
						<div class="icon">
							<i class="fas fa-truck"></i>
						</div>
						<a href="{{ route('proveedores.index') }}" class="small-box-footer">
							Más Información <i class="fas fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

				{{-- Total Compras --}}
				<div class="col-lg-3 col-6">
					<div class="small-box bg-warning">
						<div class="inner">
							<h3>{{ $comprasCount }}</h3>
							<p>Total Compras</p>
						</div>
						<div class="icon">
							<i class="fas fa-shopping-cart"></i>
						</div>
						<a href="{{ route('compras.index') }}" class="small-box-footer">
							Más Información <i class="fas fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

				{{-- Total Ventas --}}
				<div class="col-lg-3 col-6">
					<div class="small-box bg-danger">
						<div class="inner">
							<h3>{{ $ventasCount }}</h3>
							<p>Total Ventas</p>
						</div>
						<div class="icon">
							<i class="fas fa-cash-register"></i>
						</div>
						<a href="{{ route('ventas.index') }}" class="small-box-footer">
							Más Información <i class="fas fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
