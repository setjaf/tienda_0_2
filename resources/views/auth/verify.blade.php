@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Debemos verificar que tu correo es válido') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Un nuevo link se ha enviado a tu correo para realizar la verificación.') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar, por favor revisa el buzón del correo que registraste, hemos enviado un link con el cual podemos verificar que tu correo es válido.') }}
                    {{ __('Si no has recibido el link') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('da click aquí para solicitar un nuevo link') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
