@extends('layouts.app_authentication')

@section('title','Restablecer Contraseña')

@section('content')
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="{{ url('backend/dist/img/logo_audysoft.png') }}" alt="Audysoftw Logo">
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ url('/password/email') }}" method="POST">
                @csrf
                <div class="form-group has-feedback">
                    <input id="email" type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Correo Electrónico" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Enviar enlace de restablecimiento') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>		
</div>
@endsection
