@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="d-none" style="background-color: #FFFFFF80;position: absolute;width: 100%;height: 100%;z-index: 1000;box-sizing: border-box;" id="loader">
                    <div class="d-flex flex-column justify-content-center m-auto text-center">
                        <div role="status" class="spinner-border m-auto" style="width: 4rem; height: 4rem;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div>
                            Guardando entrada...
                        </div>
                    </div>
                </div>
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Cargar catálogo') }}</span>
                    {{-- @if ($cierre == null)
                    <a href="{{route('stock.showEntradas')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir a las entradas
                    </a>
                    @else
                    <a href="{{route('tienda.admin.cierres.ver',$cierre)}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir a cierre
                    </a>
                    @endif --}}
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
                        {{-- <div class="col-12 text-center row justify-content-start">
                            <label>Total pagado o por pagar:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control disabled" disabled aria-label="Total pagado por entrada" id="totalpagar" value="{{$total}}">
                            </div>
                        </div> --}}
                        {{-- <div class="form-group col-12">
                            <label for="filtro">Buscar por nombre o código de barras</label>
                            <input type="text" id="filtro" class="form-control"/>
                        </div> --}}

                        <form action="{{route('tienda.stock.cargar.catalogo.guardar')}}" method="POST" enctype="multipart/form-data" id="formAgregar" class="w-100">
                            @csrf
                            <div class="col-12 overflow-auto" id="lista-productos" style="max-height:500px;">
                                @forelse ($productos as $producto)
                                <div class="row justify-content-between border-top position-relative py-4" data-codigo="{{$producto->codigo}}">
                                    <a class="btn btn-ligth position-absolute fixed-top quitar-producto" style="width:30px;padding:0;z-index: 50;"><i class="material-icons text-danger">cancel</i></a>

                                    <input type="checkbox" name="{{$producto->codigo}}" checked class="d-none">

                                    <div class="col-12 col-md-5 d-flex flex-column justify-content-center">
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="{{url('img/productos/'.$producto->imagen)}}" alt="" class="mw-100 mh-100 m-auto">
                                            </div>
                                            <div class="h5 col-8 m-auto">{{$producto->producto}} {{$producto->tamano}}{{$producto->unidadMedida}}</div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <div class="row justify-content-end">
                                            <div class="form-group col-6 col-md-4">
                                                <label for="${data.id}">Unidades disponibles:</label>
                                                <div class="input-group">
                                                    <input type="number" name="{{$producto->codigo}}-disponible" id="{{$producto->id}}-disponible" class="form-control unidades" value="0" min="0">
                                                    @if ($producto->formaVenta != "pieza")
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">{{$producto->unidadMedida}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label for="${data.id}">Unidades deseadas:</label>
                                                <div class="input-group">
                                                    <input type="number" name="{{$producto->codigo}}-deseado" id="{{$producto->id}}-deseado" class="form-control unidades" value="0" min="0">
                                                    @if ($producto->formaVenta != "pieza")
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">{{$producto->unidadMedida}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty

                                @endforelse
                            </div>
                        </form>

                    </div>
                    <div class="col-12">
                        <div class="row justify-content-end">
                            <button id="agregaProductos" class="btn btn-primary" type="submit" form="formAgregar">
                                Agregar productos
                            </button>
                        </div>
                    </div>
                    <div class="col-12" id="prueba">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

    $(document).ready(function () {
        $(document).on('click','.quitar-producto',function (ev) {
            ev.preventDefault();

            if(this == ev.target){
                $(ev.target.parentElement).remove();
            }else{
                $(ev.target.parentElement.parentElement).remove();
            }
        });
    })

</script>
@endsection
