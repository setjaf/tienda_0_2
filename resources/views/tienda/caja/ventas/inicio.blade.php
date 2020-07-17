@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">

                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Ventas') }}</span>
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
                    <div class="row justify-content-center my-auto">

                        <div class="col-12 text-center row justify-content-center">
                            {{-- <div class="col-md-4">
                                <a href="{{route('stock.showNuevaEntrada')}}" class="text-secondary nuevaEntrada">
                                    <div class="p-3 text-center">
                                        <i class="material-icons" style="font-size: 70px">add_box</i>
                                        <p>Nueva entrada</p>
                                    </div>
                                </a>
                            </div> --}}
                        </div>
                        <div class="col-12 row overflow-auto lista-ventas" id="ventas" style="max-height:500px;">

                        @include('tienda.caja.ventas.ventas')

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
