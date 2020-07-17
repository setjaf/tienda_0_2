@extends('layouts.app')

@section('content')
<div class="container w-100 mw-100">
    <div class="row justify-content-center">
        <div class="d-none" style="background-color: #f8fafc80;position: absolute;width: 100%;height: 100%;z-index: 1000;box-sizing: border-box;" id="loader">
            <div class="d-flex flex-column justify-content-center m-auto text-center">
                <div role="status" class="spinner-border m-auto" style="width: 4rem; height: 4rem;">
                    <span class="sr-only">Loading...</span>
                </div>
                <div id="mensajeLoader">
                    Finalizando Venta...
                </div>
            </div>
        </div>
        <section class="col-md-12">
            <nav class="row">
                <div class="col text-center row justify-content-center">
                    <div class="w-100">
                        <a href="{{route("caja.showVentas")}}" target="_blank" class="text-secondary">
                            <div class="p-1 text-center">
                                <i class="material-icons" style="font-size: 40px">assignment</i>
                                <p>Ver ventas</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col text-center row justify-content-center">
                    <div class="w-100">
                        <a href="#" class="text-secondary nuevoProveedor" data-toggle="modal" data-target="#cerrarCajaModal">
                            <div class="p-1 text-center">
                                <i class="material-icons" style="font-size: 40px">exit_to_app</i>
                                <p>Salir de la caja</p>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- <div class="col text-center row justify-content-center">
                    <div class="w-100">
                        <a href="#" class="text-secondary nuevoProveedor" data-toggle="modal" data-target="#proveedorModal">
                            <div class="p-2 text-center">
                                <i class="material-icons" style="font-size: 50px">assignment_turned_in</i>
                                <p>Realizar cierre del día</p>
                            </div>
                        </a>
                    </div>
                </div> --}}
            </nav>
        </section>
        <section class="col-12 col-md-12">
            <article class="container w-100">
                <h3>Ticket</h3>
                <section class="row justify-content-center">
                    <div class="col-12">
                        <div class="alert alert-danger d-none" role="alert" id="mensajeError">

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-warning d-none" role="alert" id="mensajeAlerta">

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-success d-none" role="alert" id="mensajeExitoso">

                        </div>
                    </div>
                </section>
                <section class="row justify-content-center">
                    <div class="col-8 form-group">
                        <label for="producto">Buscar:</label>
                        <div class="w-100">
                            <input type="text" name="producto" id="inputProducto" class="form-control" autocomplete="off">
                            <ul class="position-absolute bg-white w-100 d-none" style="z-index: 100; max-height: 300px; padding:0; overflow: auto; animation: 3s infinite alternate slidein;" id="lista-buscar-productos">

                            </ul>
                        </div>
                    </div>
                    <div class="col-4 text-center">
                        <span class="h2">Total a pagar: </span><br>
                        <span class="h1">$ <span id="total">0</span></span>
                    </div>
                </section>
                <section class="row justify-content-end">
                    <button class="btn btn-danger botonLimpiarTicket" id="">
                        Limpiar ticket
                    </button>
                    <button class="btn btn-success botonFinalizarVenta" id="">
                        Finalizar Venta
                    </button>
                </section>
                <section class="row justify-content-center border border-left-0 border-right-0 " style="min-height: 100px;" id="lista-productos-ticket">
                    <div class="row justify-content-between border-top position-relative py-4" id="sinProductos">
                        <div class="col-12">
                            <span class="h4">No hay productos en el ticket</span>
                        </div>
                    </div>
                </section>
                <section class="row justify-content-end">
                    <button class="btn btn-danger botonLimpiarTicket" id="">
                        Limpiar ticket
                    </button>
                    <button class="btn btn-success botonFinalizarVenta" id="">
                        Finalizar Venta
                    </button>
                </section>
            </article>
        </section>

    </div>
</div>
@endsection

@section('modales')

<div class="modal fade" id="finalizarVentaModal" tabindex="-1" role="dialog" aria-labelledby="finalizarVentaModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Finalizar Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Por pagar:</p>
                <p class="display-4 text-center ">$<span  id="totalPagar">000</span> </p>
                <div class="form-group">
                    <label for="dinero" class="col-form-label">Dinero entregado:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" class="form-control" name="dinero" id="dinero">
                    </div>
                </div>
                <p class="text-center">Cambio:</p>
                <p class="display-4 text-center ">$<span  id="totalCambio">000</span> </p>
                <div class="form-group">
                    <label for="comentarios" class="col-form-label" >Comentarios:</label>
                    <textarea class="form-control" name="comentarios" id="comentarios"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarMarca">Delete</button> --}}
                <button class="btn btn-success" id="botonFinalizarVenta">
                    Guardar Venta
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cerrarCajaModal" tabindex="-1" role="dialog" aria-labelledby="cerrarCajaModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cerrar caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="alert alert-danger d-none" role="alert" id="mensajeErrorCierreCaja">

                    </div>
                </div>
                <div class="form-group">
                    <label for="billetes" class="col-form-label">Billetes:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" class="form-control" name="billetes" id="billetes" step="10">
                    </div>
                </div>
                <div class="form-group">
                    <label for="monedas" class="col-form-label">Monedas:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" class="form-control" name="monedas" id="monedas">
                    </div>
                </div>
                <div class="form-group">
                    <label for="monedas" class="col-form-label">Comentarios:</label>
                    <textarea class="form-control" name="comentarios" id="comentariosCierre">

                    </textarea>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarMarca">Delete</button> --}}
                <button class="btn btn-success" id="botonCerrarCaja">
                    Cerrar caja
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    let productos = [];

    let productosTicket = {};

    let productosObject = {};

    let cierreCaja = false;

    let loader = `<div class="d-flex justify-content-center">
        <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>`;

    let sinProductosTag = `<div class="row justify-content-between border-top position-relative py-4" id="sinProductos">
        <div class="col-12">
            <span class="h4">No hay productos en el ticket</span>
        </div>
    </div>`;

    function productoli(producto) {
        return `
        <li class="list-group-item w-100 producto container" style="height: 60px;"
                        data-producto="${producto.producto}"
                        data-codigo="${producto.codigo}"
                        data-id="${producto.id}"
                        data-unidadMedida="${producto.unidadMedida}"
                        data-tamano="${producto.tamano}"
                        data-precioVenta="${producto.precioVenta}"
                        data-imagen="${producto.imagen}"
                        data-disponible="${producto.disponible}"
                        data-deseado="${producto.deseado}"
                        data-formaventa="${producto.formaVenta}"
        >
            <div class="row h-100">
                <div class="col-2 h-100">
                    <img src="http://tienda.0.2.test/img/productos/${producto.imagen}" alt="" class="mw-100 mh-100 m-auto">
                </div>
                <div class="col-10 m-auto">
                    ${producto.producto} ${(producto.tamano != null?producto.tamano:"")}${producto.unidadMedida} - <b>$${producto.precioVenta}</b>
                    <span class="badge badge-secondary">${producto.disponible}</span>
                </div>
            </div>
        </li>
        `;
    }

    function productoTag(data) {
        return `
            <div class="row justify-content-between border-top position-relative py-4" data-id="${data.id}">
                <a class="btn btn-ligth position-absolute fixed-top quitar-producto" style="width:30px;padding:0;z-index: 50;"><i class="material-icons text-danger">cancel</i></a>
                <input type="hidden" name="prod-${data.id}" value="on">
                <div class="col-12 col-md-5 d-flex flex-column justify-content-center">
                    <div class="row">
                        <div class="col-4">
                            <img src="http://tienda.0.2.test/img/productos/${data.imagen}" alt="" class="mw-100 mh-100 m-auto">
                        </div>
                        <div class="h5 col-8 m-auto">${data.producto} ${(data.tamano != null?data.tamano:"")}${data.unidadmedida}</div>
                    </div>
                </div>
                <div class="col-12 col-md-7">
                    <div class="row">
                        <div class="form-group col-6 col-md-4 text-center">
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
                        <div class="form-group col-6 col-md-4 text-center">
                            <label for="preciofinal-${data.id}">Precio de venta
                                ${
                                    data.formaventa != "pieza"?
                                    `por ${data.tamano}${data.unidadmedida}`:""
                                }:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="preciofinal-${data.id}" id="preciofinal-${data.id}" class="form-control preciofinal" value="${data.precioventa}">
                            </div>
                        </div>
                        <div class="form-group col-6 col-md-4 text-center">
                            <label for="precioVentaNuevo-${data.id}">Subtotal:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="subtotal-${data.id}" id="subtotal-${data.id}" class="form-control precioventa" value="${data.precioventa}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function buscarProducto(valorBuscar, isCodigoBarras) {
        //console.log("Valor: "+valorBuscar+" Codigo:"+(isCodigoBarras?"true":"false") );

        $("#lista-buscar-productos").empty();
        $(loader).appendTo($("#lista-buscar-productos"));
        $.ajax({
            url:"{{route('caja.buscar')}}",
            data:{valorBuscar:valorBuscar},
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:"POST",
            success:function (data) {
                console.log(data);
                if(data.length > 0){
                    if (isCodigoBarras) {

                        data[0]["precioventa"] = data[0].precioVenta;
                        data[0]["unidadmedida"] = data[0].unidadMedida;
                        data[0]["formaventa"] = data[0].formaVenta;

                        agregarProductoTicket(data[0]);
                        $("#lista-buscar-productos").addClass("d-none");

                    }else{

                        $("#lista-buscar-productos").empty();
                        data.forEach(producto => {
                            $(productoli(producto)).appendTo("#lista-buscar-productos");
                        });

                    }
                }else{

                    mostrarAlerta("No se encontró ningún artículo referente a <b>\""+valorBuscar+"\"</b>");
                    $("#lista-buscar-productos").addClass("d-none");

                }


            },
            error:function (error) {
                console.log(error);

            },
        });
    }

    function agregarProductoTicket(data) {
        //console.log(data)
        $("#inputProducto").val("");

        //Verificamos que el producto tenga stock disponible
        if (data.disponible > 0) {
            if (productos.length == 0) {
                //Si es el primer producto que se agrega se limpia el contenedor para que no aparezca el mensaje de que no hay productos
                $("#lista-productos-ticket").empty();
            }
            //Verificamos si nuestro producto ya se encuentra en el ticket
            if (productos.find((id) => (id == data.id)) == undefined) {

                if (data.disponible >= 1) {
                    productos.push(data.id);
                    productosTicket[data.id] = {
                        unidades:1,
                        precioventa:data.precioventa,
                        subtotal:data.precioventa,
                        preciofinal:data.precioventa
                    };
                    productosObject[data.id] = data;
                    $( productoTag(data) ).prependTo('#lista-productos-ticket');
                }else{
                    mostrarError("No hay stock disponible de <b>\""+data.producto+" "+(data.tamano != null?data.tamano:"")+data.unidadmedida+"\"<b>");
                }

            }else{
                //Si se encuentra en el ticket, no se agrega el productoTag solo se aumenta el número de unidades
                if( productosTicket[data.id].unidades + 1 <= data.disponible ){
                    productosObject[data.id].disponible = data.disponible;
                    productosTicket[data.id].unidades++;
                    $("#unidades-"+data.id).val(productosTicket[data.id].unidades);
                }else{
                    mostrarError("No hay stock disponible de <b>\""+productosObject[data.id].producto+" "+(productosObject[data.id].tamano != null?productosObject[data.id].tamano:"")+productosObject[data.id].unidadmedida+"\"<b>");
                }

            }
            calcularTotal();
        }else{
            mostrarError("No hay stock disponible de <b>\""+data.producto+" "+(data.tamano != null?data.tamano:"")+data.unidadmedida+"\"<b>");
        }

    }

    function calcularTotal() {
        let total = 0;

        productos.forEach(id => {
            if(productosObject[id].formaventa == "pieza"){
                productosTicket[id].subtotal = productosTicket[id].unidades * productosTicket[id].preciofinal;
            }else{
                productosTicket[id].subtotal = (productosTicket[id].unidades/productosObject[id].tamano) * productosTicket[id].preciofinal;
            }
            //productosTicket[id].subtotal = productosTicket[id].unidades * productosTicket[id].preciofinal;

            $("#subtotal-"+id).val(productosTicket[id].subtotal.toFixed(2));

            total += productosTicket[id].subtotal;
        });

        $('#total').text(total.toFixed(2));

    }

    function limpiarTicket() {
        $("#total").text(0);
        $("#lista-productos-ticket").html(sinProductosTag);
        productosObject = {};
        productosTicket = {};
        productos = [];
    }

    function mostrarError(mensaje) {
        $("#mensajeError").removeClass("d-none");
        $("#mensajeError").html(mensaje);
        setTimeout(()=>{$("#mensajeError").addClass("d-none");},10000);
    }

    function mostrarErrorCierre(mensaje) {
        $("#mensajeErrorCierreCaja").removeClass("d-none");
        $("#mensajeErrorCierreCaja").text(mensaje);
        setTimeout(()=>{$("#mensajeErrorCierreCaja").addClass("d-none");},10000);
    }

    function mostrarExitoso(mensaje) {
        $("#mensajeExitoso").removeClass("d-none");
        $("#mensajeExitoso").html(mensaje);
        setTimeout(()=>{$("#mensajeExitoso").addClass("d-none");},30000);
    }

    function mostrarAlerta(mensaje) {
        $("#mensajeAlerta").removeClass("d-none");
        $("#mensajeAlerta").html(mensaje);
        setTimeout(()=>{$("#mensajeAlerta").addClass("d-none");},15000);
    }

    function finalizarVenta(comentarios) {
        console.log(comentarios);
        $('#mensajeLoader').text('Finalizar venta');
        $("#loader").removeClass("d-none");

        $.ajax({
            url:"{{route('caja.venta.finalizar')}}",
            data:{
                productos:productosTicket,
                total:$("#total").text(),
                comentarios:comentarios,
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:"POST",
            success:function (data) {
                console.log(data);
                $("#loader").addClass("d-none");

                if(data.ok == true){
                    limpiarTicket();
                    mostrarExitoso("Venta guardada correctamente.");

                }else{
                    limpiarTicket();
                    mostrarError("No se ha guardado la venta de forma correcta, se ha guardado como error");
                }

            },
            error:function (error) {
                console.log(error);
            },
        });
    }

    function cerrarCaja(billetes, monedas, comentarios) {
        $('#mensajeLoader').text('Cerrando caja');
        $("#loader").removeClass("d-none");

        $.ajax({

            url:"{{route('caja.cierre.usuario')}}",
            data:{
                billetes:billetes,
                monedas:monedas,
                comentarios:comentarios,
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:"POST",
            success:function (data) {
                console.log(data);


                if(data.ok){
                    window.location.replace(data.redirectTo);

                }else{
                    $("#loader").addClass("d-none");
                    $("#cerrarCajaModal").modal("show");
                    mostrarErrorCierre("Revisa los campos nuevamente")
                }

            },
            error:function (error) {
                console.log(error);
                $("#cerrarCajaModal").modal("show");
                mostrarErrorCierre(error.message);
            },

        });

    }

    function calcularCambio() {
        let cambio = parseFloat($("#dinero").val()) - parseFloat($("#totalPagar").text());
        $("#totalCambio").text(cambio.toFixed(2));
    }

    $(document).ready(function () {

        // window.addEventListener('beforeunload', (event) => {
        //     // Cancel the event as stated by the standard.
        //     event.preventDefault();
        //     // Chrome requires returnValue to be set.
        //     event.returnValue = 'poaishdj';
        // });

        $("#inputProducto").keyup(function (ev) {
            ev.preventDefault();
            let isCodigoBarras = false;

            if(ev.keyCode == 27 && !$("#lista-buscar-productos").hasClass("d-none")){
                $("#lista-buscar-productos").addClass("d-none");
            }else if (ev.keyCode == 13){
                isCodigoBarras = ev.target.value.match("^\\d+$")
                $("#lista-buscar-productos").removeClass("d-none");

                buscarProducto(ev.target.value, isCodigoBarras);
                // if (isCodigoBarras) {
                //     buscarProducto(ev.target.value, isCodigoBarras);
                // }else{
                //     buscarPorNombre(ev.target.value);
                // }

            }
        });

        // $("#inputProducto").blur(function (ev) {
        //     //console.log(ev);

        //     //$("#lista-buscar-productos").addClass("d-none");
        // });

        $(document).on('click','.quitar-producto',function (ev) {
            ev.preventDefault();

            if(this == ev.target){
                $(ev.target.parentElement).remove();
                productos = productos.filter(function (value) {
                    return value != ev.target.parentElement.dataset.id;
                });
                delete productosObject[ev.target.parentElement.dataset.id];
                delete productosTicket[ev.target.parentElement.dataset.id];
            }else{
                $(ev.target.parentElement.parentElement).remove();
                productos = productos.filter(function (value) {
                    return value != ev.target.parentElement.parentElement.dataset.id;
                });
                delete productosObject[ev.target.parentElement.parentElement.dataset.id];
                delete productosTicket[ev.target.parentElement.parentElement.dataset.id];
            }
            if (productos.length == 0) {
                $("#lista-productos-ticket").html(sinProductosTag);
            }
            calcularTotal();

        });

        $(document).on('click','.producto',function (ev) {
            console.log(ev);
            //console.log($(":focus"));
            //console.log($("#lista-buscar-productos").is(":focus"));

            agregarProductoTicket($(this).data());

            $("#lista-buscar-productos").addClass("d-none");

            //$(this).toggleClass('active');
            // $('#filtro').val("");
            // $('#filtro').change();
            //$(this).remove()
            $("#inputProducto").focus();
        })

        $(document).on('change','.unidades , .preciofinal', function (ev) {
            console.log(ev);
            console.log(parseFloat(ev.target.value));


            let idProducto = ev.target.id.split('-')[1];
            let dato =  ev.target.id.split('-')[0].toLowerCase();

            if(ev.target.value == '' || (parseFloat(ev.target.value) < 1 && dato == "unidades")){
                $(ev.target).val(productosTicket[idProducto][dato]);
            }else{
                if( (dato == "unidades" && productosObject[idProducto]["disponible"] >= parseFloat(ev.target.value)) || dato != "unidades" ){
                    productosTicket[idProducto][dato] = parseFloat(ev.target.value);
                    calcularTotal();
                }else{
                    $(this).val(productosTicket[idProducto][dato]);
                    mostrarError("No hay stock disponible de <b>\""+productosObject[idProducto].producto+" "+(productosObject[idProducto].tamano != null?productosObject[idProducto].tamano:"")+productosObject[idProducto].unidadmedida+"\"<b>");
                }
            }

        });

        $(".botonLimpiarTicket").click(function (ev) {
            ev.preventDefault();
            limpiarTicket();
        });

        $(".botonFinalizarVenta").click(function (ev) {
            ev.preventDefault();
            $("#finalizarVentaModal").modal("show");
            $("#totalPagar").text($("#total").text());
            $("#totalCambio").text("0");
            $("#comentarios").val("");
            $("#dinero").val("").focus();

        });

        $("#dinero").keyup(function (ev) {
            if (ev.keyCode == 13){
                calcularCambio();
            }
        });

        $("#dinero").change(function (ev) {
            calcularCambio()
        });

        $("#botonFinalizarVenta").click(function (ev) {
            ev.preventDefault();
            $("#finalizarVentaModal").modal("hide");
            finalizarVenta($("#comentarios").val());
        });

        $("#botonCerrarCaja").click(function (ev) {
            let $monedas = $("#monedas").val();
            let $billetes = $("#billetes").val();
            if($monedas != "" && $billetes != ""){
                $("#cerrarCajaModal").modal("hide");
                cerrarCaja(parseFloat($billetes),parseFloat($monedas),$("#comentariosCierre").val());
            }else{
                mostrarErrorCierre("Revisa que los campos de billetes y monedas estén llenos de forma correcta.");
            }
        })

    });


</script>
@endsection
