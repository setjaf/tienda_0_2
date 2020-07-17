@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Cierre '.$cierre->created_at->format('d-m-Y H:i')) }}</span>
                    <a href="{{route('tienda.admin.cierres')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir a cierres
                    </a>
                </div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if(session()->has('messageError'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('messageError') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ implode('', $errors->all(':message')) }}
                        </div>
                    @endif
                    <div class="container-fuid">

                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <span class="h4">Total dinero:</span>
                                <br>
                                <span class="display-4">${{$cierre->total}}</span>
                            </div>
                            <div class="col-md-4">
                                <span class="h4">Total dinero esperado:</span>
                                <br>
                                <span class="display-4">${{$cierre->totalDineroEsperado}}</span>
                            </div>
                        </div>

                        <div class="row mt-4 justify-content-center">
                            <div class="col-md-4 text-center align-self-center">
                                <div class="d-flex flex-column">
                                    <div>
                                        <span class="h5"> Total dinero cierre anterior:</span>
                                        <br>
                                        <span class="h2">${{$cierre->totalDineroAnterior}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 text-center align-self-center">
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="mx-2 text-center">
                                        <span class="h5"> Billetes:</span>
                                        <br>
                                        <span class="h2">${{$cierre->billetes}}</span>
                                    </div>
                                    <div class="mx-2 text-center">
                                        <span class="h5"> Monedas:</span>
                                        <br>
                                        <span class="h2">${{$cierre->monedas}}</span>
                                    </div>
                                </div>
                                <div class="text-justify mt-3">
                                    <span class="h5">Comentarios:</span>
                                    <br>
                                    <p>{{$cierre->comentarios}}</p>
                                </div>
                            </div>
                        </div>

                        <h2 class="mt-3">Ventas ${{$cierre->totalVentas}}</h2>

                        <div class="row" id="ventas">

                            @include('tienda.admin.cierres.ventas')
                        </div>

                        <h2 class="mt-3">Gastos ${{$cierre->totalGastos}}</h2>

                        <div class="row" id="gastos">
                            @include('tienda.admin.cierres.gastos')
                        </div>

                        <h2 class="mt-3">Entradas ${{$cierre->totalEntradas}}</h2>

                        <div class="row" id="entradas">
                            @include('tienda.admin.cierres.entradas')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
