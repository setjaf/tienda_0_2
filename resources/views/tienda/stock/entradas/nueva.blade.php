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
                    <span class="h4">{{ __('Nueva entrada') }}</span>
                    <a href="{{route('stock.showEntradas')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir a las entradas
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
                    <div class="row justify-content-center my-auto">
                        <div class="col-12 text-center row justify-content-start">
                            <label>Total pagado o por pagar:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control disabled" disabled aria-label="Total pagado por entrada" id="totalpagar" value="0">
                            </div>
                        </div>

                        <form action="" method="POST" enctype="multipart/form-data" id="formAsosciar" class="w-100">
                            <div class="col-12 overflow-auto" id="lista-productos-entrada" style="max-height:500px;">
                                {{-- <div class="row justify-content-between border-top position-relative py-4">
                                    <button class="btn btn-ligth position-absolute fixed-top quitar-producto" id=""><i class="material-icons text-danger">cancel</i></button>
                                    <input type="hidden" name="prod-1" value="on">
                                    <div class="col-12 col-md-5 d-flex flex-column justify-content-center">
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="http://tienda.0.2.test/img/productos/94_180520200328.jpg" alt="" class="mw-100 mh-100 m-auto">
                                            </div>
                                            <div class="h5 col-8 m-auto">Nombre producto 000ml</div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <div class="row">
                                            <div class="form-group col-6 col-md-4">
                                                <label for="unidades-1">Unidades:</label>
                                                <input type="text" name="unidades-1" id="unidades-1" class="form-control">
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label for="precioCompra-1">Precio de compra:</label>
                                                <input type="text" name="precioCompra-1" id="precioCompra-1" class="form-control">
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label for="precioVentaNuevo-1">Precio de venta:</label>
                                                <input type="text" name="precioVentaNuevo-1" id="precioVenta-1" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </form>

                    </div>
                    <div class="col-12">
                        <div class="row justify-content-end">
                            <button id="agregaProductos" class="btn btn-primary" data-toggle="modal" data-target="#agregarProductosModal" >
                                Agregar productos
                            </button>
                            <button id="guardarEntrada" class="btn btn-primary">
                                Guardar entrada
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


@section('modales')
<div class="modal fade" id="agregarProductosModal" tabindex="-1" role="dialog" aria-labelledby="agregarProductosModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Agregar productos a entrada nueva
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="h2"></p>
            <div class="modal-body">
                <div class="form-group col-12">
                    <label for="filtro">Buscar por nombre o código de barras</label>
                    <input type="text" id="filtro" class="form-control"/>
                </div>
                <div id="productos" style="max-height: 50vh; overflow: auto;">

                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarCategoria">Delete</button> --}}
                {{-- <button type="button" class="btn btn-primary" id="botonFormAsociarCategoria">Guardar</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script>
        let productos = [];

        let productosObject = {};

        let preciosNuevos = {};

        let loader = `<div class="d-flex justify-content-center">
            <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>`;

        function productoTag(data) {

            productosObject[data.id] = {
                unidades:1,
                preciocompra:0,
                precioventa:data.precioventa,
            }

            preciosNuevos[data.id] = {
                precioventanuevo:data.precioventa,
                formaVenta: data.formaventa,
                tamano: data.tamano
            }

            return `
            <div class="row justify-content-between border-top position-relative py-4" data-id="${data.id}">
                <a class="btn btn-ligth position-absolute fixed-top quitar-producto" style="width:30px;padding:0;z-index: 50;"><i class="material-icons text-danger">cancel</i></a>
                <input type="hidden" name="prod-${data.id}" value="on">
                <div class="col-12 col-md-5 d-flex flex-column justify-content-center">
                    <div class="row">
                        <div class="col-4">
                            <img src="${data.imagen}" alt="" class="mw-100 mh-100 m-auto">
                        </div>
                        <div class="h5 col-8 m-auto">${data.producto} ${data.tamano}${data.unidadmedida}</div>
                    </div>
                </div>
                <div class="col-12 col-md-7">
                    <div class="row">
                        <div class="form-group col-6 col-md-4">
                            <label for="unidades-${data.id}">Unidades:</label>
                            <div class="input-group">
                                <input type="number" name="unidades-${data.id}" id="unidades-${data.id}" class="form-control unidades" value="1" min="1">
                                ${
                                    data.formaventa != "pieza"?
                                    `<div class="input-group-append">
                                        <span class="input-group-text">${data.unidadmedida}</span>
                                    </div>`:""
                                }
                            </div>
                        </div>
                        <div class="form-group col-6 col-md-4">
                            <label for="precioCompra-${data.id}">Precio de compra
                                ${
                                    data.formaventa != "pieza"?
                                    `por ${data.tamano}${data.unidadmedida}`:""
                                }:
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="precioCompra-${data.id}" id="precioCompra-${data.id}" class="form-control preciocompra" value="0">
                            </div>
                        </div>
                        <div class="form-group col-6 col-md-4">
                            <label for="precioVentaNuevo-${data.id}">Precio de venta
                                ${
                                    data.formaventa != "pieza"?
                                    `por ${data.tamano}${data.unidadmedida}`:""
                                }:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="precioVentaNuevo-${data.id}" id="precioVentaNuevo-${data.id}" class="form-control precioventa" value="${data.precioventa}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }

        function filtrar($event, items) {
            items.addClass('d-none').filter(function (item)
            {
                return ($(this)[0].dataset.producto.toLowerCase().includes($($event.target).val().toLowerCase())) | ($(this)[0].dataset.codigo.includes($($event.target).val().toLowerCase()));
            }).removeClass('d-none');
        }

        function fetch_data(data,url) {

            $.ajax({
                url:url,
                data: data,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:"POST",
                success:function(data)
                {
                    //console.log(data);
                    $("#productos").html(data);
                },
                error:function (error) {
                    console.log(error);
                }
            });

        }

        function calcularTotal() {
            let total = 0;

            productos.forEach(id => {
                if(preciosNuevos[id].formaVenta == "pieza"){
                    total += productosObject[id].unidades * productosObject[id].preciocompra;
                }else{
                    total += (productosObject[id].unidades/preciosNuevos[id].tamano) * productosObject[id].preciocompra;
                }

            });

            $('#totalpagar').val(total);

        }

        $(document).ready(function () {

            $('#filtro').on('keyup change',function ($event) {
                var items = $('#productos ul li.producto');
                filtrar($event, items);
            });

            $("#agregaProductos").on('click',function (ev) {
                ev.preventDefault();

                $("#productos").empty();
                $(loader).clone().appendTo($("#productos"));

                $('#filtro').val("");

                data={
                    productos:productos,
                };
                url='{{route('stock.entradaFetchProductos')}}';

                fetch_data(data,url)
            });

            $(document).on('click','.quitar-producto',function (ev) {
                ev.preventDefault();

                if(this == ev.target){
                    $(ev.target.parentElement).remove();
                    productos = productos.filter(function (value) {
                        return value != ev.target.parentElement.dataset.id;
                    });
                    delete productosObject[ev.target.parentElement.dataset.id];
                    delete preciosNuevos[ev.target.parentElement.dataset.id];
                }else{
                    $(ev.target.parentElement.parentElement).remove();
                    productos = productos.filter(function (value) {
                        return value != ev.target.parentElement.parentElement.dataset.id;
                    });
                    delete productosObject[ev.target.parentElement.parentElement.dataset.id];
                    delete preciosNuevos[ev.target.parentElement.parentElement.dataset.id];
                }
                calcularTotal();

            });

            $(document).on('click','.producto',function (ev) {

                productos.push($(this).data().id);
                $( productoTag($(this).data()) ).appendTo('#lista-productos-entrada')
                $(this).toggleClass('active');
                // $('#filtro').val("");
                // $('#filtro').change();
                $('#filtro').focus();
                $(this).remove()
            })

            $(document).on('change','.unidades , .preciocompra', function (ev) {
                let idProducto = ev.target.id.split('-')[1];
                let dato =  ev.target.id.split('-')[0].toLowerCase();
                productosObject[idProducto][dato] = parseInt(ev.target.value);
                calcularTotal();
            });

            $(document).on('change','.precioventa', function (ev) {
                let idProducto = ev.target.id.split('-')[1];
                let dato =  ev.target.id.split('-')[0].toLowerCase();
                preciosNuevos[idProducto][dato] = parseInt(ev.target.value);
            });

            $('#guardarEntrada').on('click',function (ev) {
                ev.preventDefault();

                $("#loader").toggleClass('d-none');
                $("#loader").toggleClass('d-flex');

                data={
                    productos:productos,
                    productosObj:productosObject,
                    preciosNuevos:preciosNuevos,
                    total:$('#totalpagar').val(),
                };
                url='{{route('stock.nuevaEntrada')}}';

                $.ajax({
                    url:url,
                    data: data,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method:"POST",
                    success:function(data)
                    {
                        console.log(data);
                        if (data.ok) {
                            window.location.replace(data.redirectTo);
                        }else{
                            $("#loader").toggleClass('d-none');
                            $("#loader").toggleClass('d-flex');
                        }
                    },
                    error:function (error) {
                        console.log(error);
                    }
                });

            })

        });

    </script>
@endsection
