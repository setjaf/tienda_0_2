@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Stock') }}</span>
                    <a href="{{route('tienda')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir al inicio
                    </a>
                </div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row justify-content-center my-auto">

                        <div class="col-12 text-center row justify-content-center">
                            <div class="col-md-4 col-6">
                                <a href="{{route('stock.showNuevo')}}" class="text-secondary">
                                    <div class="p-3 text-center">
                                        <i class="material-icons" style="font-size: 70px">add_box</i>
                                        <p>Crear nuevo producto</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6">
                                <a href="{{route('stock.showMarcas')}}" class="text-secondary">
                                    <div class="p-3 text-center">
                                        <i class="material-icons" style="font-size: 70px">loyalty</i>
                                        <p>Marcas</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6">
                                <a href="{{route('stock.showCategorias')}}" class="text-secondary">
                                    <div class="p-3 text-center">
                                        <i class="material-icons" style="font-size: 70px">label</i>
                                        <p>Categorias</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6">
                                <a href="{{route('stock.showEntradas')}}" class="text-secondary">
                                    <div class="p-3 text-center">
                                        <i class="material-icons" style="font-size: 70px">input</i>
                                        <p>Entradas de productos</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6">
                                <a href="{{route('proveedores.show')}}" class="text-secondary">
                                    <div class="p-3 text-center">
                                        <i class="material-icons" style="font-size: 70px">local_shipping</i>
                                        <p>Proveedores</p>
                                    </div>
                                </a>
                            </div>

                        </div>
                        <div class="col-12">
                            <h2>Productos en stock</h2>
                        </div>
                        <div class="col-12 row justify-content-center">
                            <form id="formBuscar" class="col-12 row justify-content-center">
                                @csrf
                                <input type="hidden" name="buscar" value="1">
                                <div class="form-group col-md col-6 d-flex justify-content-center flex-column">
                                    <label for="codigo">Código de barras:</label>
                                    <input type="text" name="codigo" id="codigo" placeholder="1000000000001" class="form-control">
                                </div>
                                <div class="form-group col-md col-6 d-flex justify-content-center flex-column">
                                    <label for="nombre">Nombre del producto:</label>
                                    <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control">
                                </div>
                                <div class="form-group col-md col-6 d-flex justify-content-center flex-column">
                                    <label for="marca">Marca:</label>
                                    <select name="marca" id="marca" class="form-control">
                                        <option value="">Elige una marca</option>
                                        @foreach ($tiendaLog->marcas as $marca)
                                            <option value="{{$marca->id}}" >{{$marca->marca}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md col-6 d-flex flex-column justify-content-around">
                                    <button class="btn btn-primary" id="buscar"> Buscar </button>
                                </div>
                                <div class="form-group col-12 d-flex justify-content-center">
                                    @forelse ($tiendaLog->categorias as $categoria)
                                        <div class="btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-outline-dark">
                                                <input type="checkbox" autocomplete="off" name="cat-{{$categoria->id}}">
                                                <i class="material-icons" style="color:{{$categoria->color}};vertical-align:bottom;cursor:default;" title="{{$categoria->categoria}}">label</i>
                                                {{$categoria->categoria}}
                                            </label>
                                        </div>
                                    @empty

                                    @endforelse
                                </div>

                            </form>
                        </div>
                        @if ($tiendaLog->marcas->count() == 0)
                        <div class="col-12 text-center">
                            <a href="{{route('tienda.stock.cargar.catalogo')}}" class="btn btn-success">Agregar productos y marcas del catálogo</a>
                        </div>
                        @endif

                        <div class="col-12 row lista-producto justify-content-center" id="productos">

                            @include('tienda.stock.productos')

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function FDtoJSON(FormData) {
        let object = {};
        object['categorias'] = [];
        FormData.forEach(
            (value,key)=>{
                if (key.includes("cat-")) {
                    object['categorias'].push(key.split('cat-')[1]);
                }else if(value!=''){
                    object[key]=value;
                }
            }
        );
        return object;
    }

    function fetch_data(data,url){
        $.ajax({
            url:url,
            data: data,
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:"POST",
            success:function(data)
            {
                $("#productos").html(data);
            },
            error:function (error) {
                console.log(error);
            }
        });
    }

    let loader = `
    <div class="d-flex justify-content-center">
        <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    `;



    $(document).ready(function () {
        $(document).on('click','.pagination a, .page-link a',function (ev) {
            ev.preventDefault();
            let page = $(this).attr('href').split('page=')[1];

            $("#productos").empty();
            $(loader).clone().appendTo($("#productos"));

            let data = {page:page};
            let url = $(this).attr('href');
            fetch_data(data, url);
        });

        $("#buscar").on('click',function (ev) {
            ev.preventDefault();

            $("#productos").empty();
            $(loader).clone().appendTo($("#productos"));

            let data = FDtoJSON(new FormData($("#formBuscar")[0]));
            let url = '{{route('tienda.stock.buscar')}}';

            fetch_data(data, url);

        });

        // $(".btn-group-toggle").on('click',function () {
        //     $(document).focus();
        // });
    });
</script>
@endsection
