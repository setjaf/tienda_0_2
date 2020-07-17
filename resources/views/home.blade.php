@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Si te encuentras en esta página es debido a que no eres administrador
                    y tampoco se ha abierto una tienda en el dispositivo. Solicita al administrador de la tienda
                    que realice la apertura de la tienda en el dispositivo para que puedas comenzar a trabajar.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
