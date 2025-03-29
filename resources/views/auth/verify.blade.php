@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1 class="text-center">{{ __('Verifica tu dirección de correo electrónico') }}</h1>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">{{ __('Correo de verificación') }}</h3>
                    </div>
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Se ha enviado un nuevo enlace de verificación a tu correo.') }}
                            </div>
                        @endif

                        <p>{{ __('Antes de continuar, por favor revisa tu correo electrónico para el enlace de verificación.') }}</p>
                        <p>{{ __('Si no has recibido el correo') }}:</p>

                        <div class="d-flex justify-content-center">
                            <form method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Haz clic aquí para solicitar otro') }}
                                </button>
                            </form>
                        </div>

                        <p class="text-muted text-center mt-3">
                            {{ __('A veces puede tardar unos minutos en llegar.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
