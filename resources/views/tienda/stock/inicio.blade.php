@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Stock') }}</div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="row justify-content-center my-auto">

                        <div class="col-12 text-center row">
                            <div class="col-md-4">
                                <a href="{{route('stock.showNuevo')}}" class="text-secondary">
                                    <div class="p-5 text-center">
                                        <i class="material-icons" style="font-size: 70px">add_box</i>
                                        <p>Crear nuevo producto</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4">
                                <a href="{{route('stock.showMarcas')}}" class="text-secondary">
                                    <div class="p-5 text-center">
                                        <i class="material-icons" style="font-size: 70px">loyalty</i>
                                        <p>Marcas</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4">
                                <a href="{{url('super/categorias/')}}" class="text-secondary">
                                    <div class="p-5 text-center">
                                        <i class="material-icons" style="font-size: 70px">label</i>
                                        <p>Categorias</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 row overflow-auto lista-producto" style="max-height:500px;">
                        @unless (empty($stock))
                            @foreach ($stock as $producto)
                                <div class="col-md-6 my-2 producto"
                                    data-nombre='{{$producto->producto}}'
                                    data-codigo='{{$producto->id}}'
                                >
                                    <div class="card mx-auto d-flex">

                                        <div class="row no-gutters">

                                            <div class="col-4 overflow-hidden d-flex">
                                                <img src="{{url('img/productos/'.$producto->imagen)}}" alt="No se encontró la imagen" class="mw-100 mh-100 m-auto">
                                            </div>

                                            <div class="col-8">
                                                <div class="card-body">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1">{{$producto->producto}}</h5>
                                                        <small>{{$producto->tamano}} {{$producto->unidadMedida}}</small>
                                                    </div>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            {{$producto->disponible}} @if ($producto->formaVenta == 'granel')
                                                                {{$producto->unidadMedida}}
                                                            @else
                                                                {{'piezas'}}
                                                            @endif
                                                        </li>
                                                        <li class="list-group-item">${{$producto->precioVenta}}</li>
                                                    </ul>
                                                    {{-- <p class="card-text">{{$producto->cantidadDisponible}}</p>
                                                    <p class="card-text text-muted">{{$producto->id}}</p> --}}
                                                    <a href="{{route('stock.showEditar',$producto->id)}}" class="btn btn-link">Editar producto</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            </div>

                            <div class="w-100"></div>

                            {{-- <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                    </li>
                                </ul>
                            </nav> --}}

                            {{$stock->links()}}
                        @else
                        <div class="col-12 my-2">
                            <span class="display-4">No hay productos registrados</span>
                        </div>
                        @endunless

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
