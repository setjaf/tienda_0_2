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
                            Guardando venta...
                        </div>
                    </div>
                </div>

                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Venta '.$venta->created_at->format('d-m-Y H:i')) }}</span>
                    @if ($cierre == null)
                    <a href="{{route('caja.showVentas')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir a ventas
                    </a>
                    @else
                    <a href="{{route('tienda.admin.cierres.ver',$cierre)}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir a cierre
                    </a>
                    @endif
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
                        <div class="col-md-6 text-center">
                            <span class="h2">Total pagado: </span><br>
                            <span class="h1">$ <span id="total">{{$venta->importe}}</span></span>
                        </div>
                        <div class="col-md-6 text-justify">
                            <span class="h2">Comentarios: </span><br>
                            <p class="">{{$venta->comentarios}}</p>
                        </div>

                        <form action="" method="POST" enctype="multipart/form-data" id="formAsosciar" class="w-100">
                            <div class="col-12 overflow-auto pt-2" id="lista-productos-venta" style="max-height:500px;">
                                @forelse ($venta->productos as $producto)
                                <div class="row justify-content-between border-top position-relative py-2" data-id="{{$producto->id}}">
                                    <a class="btn btn-ligth position-absolute fixed-top quitar-producto d-none" style="width:30px;padding:0;z-index: 50;"><i class="material-icons text-danger">cancel</i></a>
                                    <input type="hidden" name="prod-{{$producto->id}}" value="on">
                                    <div class="col-12 col-md-5 d-flex flex-column justify-content-center">
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="{{url('img/productos/'.$producto->imagen)}}" alt="" class="mw-100 mh-100 m-auto">
                                            </div>
                                            <div class="h5 col-8 m-auto text-truncate">{{$producto->producto}} {{$producto->tamano}}{{$producto->unidadMedida}}</div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <div class="row">
                                            <div class="form-group col-6 col-md-3 text-center">
                                                <label>Unidades</label>
                                                <div class="h2">
                                                    {{$producto->pivot->unidades}}
                                                    @if ($producto->formaVenta != "pieza")
                                                        {{$producto->unidadMedida}}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-6 col-md-3 text-center">
                                                <label>Precio de venta
                                                    @if ($producto->formaVenta != "pieza")
                                                        por {{$producto->tamano}}{{$producto->unidadM2edida}}
                                                    @endif
                                                </label>
                                                <div class="h2">
                                                    ${{$producto->pivot->precioVenta}}
                                                </div>
                                            </div>
                                            <div class="form-group col-6 col-md-3 text-center">
                                                <label>Precio de venta final
                                                    @if ($producto->formaVenta != "pieza")
                                                        por {{$producto->tamano}}{{$producto->unidadM2edida}}
                                                    @endif
                                                </label>
                                                <div class="h2">
                                                    ${{$producto->pivot->precioFinal}}
                                                </div>
                                            </div>
                                            <div class="form-group col-6 col-md-3 text-center">
                                                <label>Subtotal</label>
                                                <div class="h2">
                                                    ${{$producto->pivot->subtotal}}
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
                    {{-- <div class="col-12">
                        <div class="row justify-content-end">
                            <button id="agregaProductos" class="btn btn-primary d-none" data-toggle="modal" data-target="#agregarProductosModal" >
                                Agregar productos
                            </button>
                            <button id="guardarVenta" class="btn btn-primary d-none">
                                Guardar venta
                            </button>
                            <button id="editarVenta" class="btn btn-primary">
                                Editar venta
                            </button>

                        </div>
                    </div> --}}
                    <div class="col-12" id="prueba">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
