@extends('layouts.app')

@section('title', 'Crear Producto')

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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3>@yield('title')</h3>
                        </div>
                        <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <!-- Categoría -->
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Categoría <strong style="color:red;">(*)</strong></label>
                                            <select class="form-control" name="categoria_id" id="categoria" required>
                                                <option value="">Seleccione Categoría</option>
                                                @foreach($categorias as $categoria)
                                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                                @endforeach
                                            </select>
                                            @error('categoria_id') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Proveedor -->
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Proveedor <strong style="color:red;">(*)</strong></label>
                                            <select class="form-control" name="proveedor_id" id="proveedor" required>
                                                <option value="">Seleccione Proveedor</option>
                                                @foreach($proveedores as $proveedor)
                                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                                @endforeach
                                            </select>
                                            @error('proveedor_id') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Otros campos -->
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre <strong style="color:red;">(*)</strong></label>
                                            <input type="text" class="form-control" name="nombre" placeholder="" value="{{ old('nombre') }}" required>
                                            @error('nombre') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Descripción <strong style="color:red;">(*)</strong></label>
                                            <input type="text" class="form-control" name="descripcion" placeholder="" value="{{ old('descripcion') }}" required>
                                            @error('descripcion') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Precio <strong style="color:red;">(*)</strong></label>
                                            <input type="number" class="form-control" name="precio" placeholder="" value="{{ old('precio') }}" step="0.01" required>
                                            @error('precio') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Stock <strong style="color:red;">(*)</strong></label>
                                            <input type="number" class="form-control" name="stock" placeholder="" value="{{ old('stock') }}" required>
                                            @error('stock') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Fecha Vencimiento <strong style="color:red;">(*)</strong></label>
                                            <input type="date" class="form-control" name="fecha_vencimiento" placeholder="" value="{{ old('fecha_vencimiento') }}" required>
                                            @error('fecha_vencimiento') 
                                                <div class="text-danger">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Imagen <strong style="color:red;">(*)</strong></label>
                                        <input type="file" class="form-control" name="img" accept="image/*" required>
                                        @error('img') 
                                            <div class="text-danger">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="estado" value="1">
                                <input type="hidden" class="form-control" name="registradopor" value="{{ Auth::user()->id }}">
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
                                    </div>
                                    <div class="col-lg-2 col-xs-4">
                                        <a href="{{ route('productos.index') }}" class="btn btn-danger btn-block btn-flat">Atras</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
