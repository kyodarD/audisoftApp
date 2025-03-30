@extends('layouts.app')

@section('title','Editar Producto')

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
                        <form method="POST" action="{{ route('productos.update', $producto) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <!-- Categoría -->
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Categoría <strong style="color:red;">(*)</strong></label>
                                            <select class="form-control" name="categoria_id" id="categoria" disabled>
                                                @foreach($categorias as $categoria)
                                                    <option {{ $categoria->id == $producto->categoria_id ? 'selected' : '' }} value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Proveedor -->
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Proveedor <strong style="color:red;">(*)</strong></label>
                                            <select class="form-control" name="proveedor_id" id="proveedor">
                                                <option value>Seleccione Proveedor</option>
                                                @foreach($proveedores as $proveedor)
                                                    <option {{ $proveedor->id == $producto->proveedor_id ? 'selected' : '' }} value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Otros campos -->
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre <strong style="color:red;">(*)</strong></label>
                                            <input type="text" class="form-control" name="nombre" placeholder="" autocomplete="off" value="{{ $producto->nombre }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Descripción <strong style="color:red;">(*)</strong></label>
                                            <input type="text" class="form-control" name="descripcion" placeholder="" autocomplete="off" value="{{ $producto->descripcion }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Precio <strong style="color:red;">(*)</strong></label>
                                            <input type="number" class="form-control" name="precio" placeholder="" autocomplete="off" value="{{ $producto->precio }}" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Stock <strong style="color:red;">(*)</strong></label>
                                            <input type="number" class="form-control" name="stock" placeholder="" autocomplete="off" value="{{ $producto->stock }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Fecha Vencimiento <strong style="color:red;">(*)</strong></label>
                                            <input type="date" class="form-control" name="fecha_vencimiento" placeholder="" autocomplete="on" value="{{ $producto->fecha_vencimiento }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Imagen -->
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Imagen <strong style="color:red;">(*)</strong></label>
                                        <input type="file" class="form-control" name="img" accept="image/*" autocomplete="off">
                                        @if ($producto->img)
                                            <img src="{{ Storage::disk('s3')->url($producto->img) }}" alt="{{ $producto->nombre }}" style="width:100px; height:auto;" />
                                        @else                                              
                                            <span>No image</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Estado y Registrado Por -->
                                <input type="hidden" class="form-control" name="estado" value="1">
                                <input type="hidden" class="form-control" name="registradopor" value="{{ Auth::user()->id }}">
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Actualizar</button>
                                    </div>
                                    <div class="col-lg-2 col-xs-4">
                                        <a href="{{ route('productos.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
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
