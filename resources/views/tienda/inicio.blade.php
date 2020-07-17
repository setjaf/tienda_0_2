@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __($tiendaLog->nombre) }}</span>
                    {{-- <a href="{{route('tienda')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir al inicio
                    </a> --}}
                </div>

                <div class="card-body">

                    <div class="alert alert-success d-none" role="alert" id="mensajeExitoso">

                    </div>
                    <div class="alert alert-danger d-none" role="alert" id="mensajeError">

                    </div>
                    <div class="row justify-content-center">

                        <div class="col-md-4">
                            <a href="{{route('caja')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">storefront</i>
                                    <p>Caja</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{route('tienda.stock')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">fastfood</i>
                                    <p>Stock</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{route('proveedores.show')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">local_shipping</i>
                                    <p>Proveedores</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="#" class="text-secondary asistenciaEmpleado" data-toggle="modal" data-target="#asistenciaModal">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">book_online</i>
                                    <p>Registrar Asistencia</p>
                                </div>
                            </a>
                        </div>

                        @if (Auth::user()->id == $tiendaLog->administrador->id)
                        <div class="col-md-4">
                            <a href="{{route('tienda.admin')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">account_box</i>
                                    <p>Administración</p>
                                </div>
                            </a>
                        </div>
                        @endif


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('modales')

<div class="modal fade" id="asistenciaModal" tabindex="-1" role="dialog" aria-labelledby="asistenciaModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Asociar empleados a la tienda
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="h2"></p>
            <div class="modal-body">
                {{-- <div class="form-group col-12">
                    <label for="filtro">Buscar por nombre o correo electrónico</label>
                    <input type="text" id="filtro" class="form-control"/>
                </div> --}}
                <form action="" method="POST" enctype="multipart/form-data" id="formAsosciar">
                    <input type="hidden" name="categoria" id="idcategoria">

                    <div id="empleados" style="max-height: 50vh; overflow: auto;">



                    </div>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarCategoria">Delete</button> --}}
                {{-- <button type="button" class="btn btn-primary" id="botonFormAsociarEmpleado">Guardar</button> --}}
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')

    <script>
        function FDtoJSON(FormData) {
            let object = {};
            object['productos'] = {};
            FormData.forEach(
                (value,key)=>{
                    if (key.includes("prod-")) {
                        object['productos'][key.split('prod-')[1]] = {precio:0};
                    }else if (key.includes("precio-")) {
                        if (object['productos'].hasOwnProperty(key.split('precio-')[1])) {
                            object['productos'][key.split('precio-')[1]]['precio']=value;
                        }
                    }else if(value!=''){
                        object[key]=value;
                    }
                }
            );
            return object;
        }

        function fetch_data(url='{{route('tienda.showEmpleados')}}') {

            $.ajax({
                url:url,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:"POST",
                success:function(data)
                {
                    //console.log(data);
                    $("#empleados").html(data);
                },
                error:function (error) {
                    console.log(error);
                }
            });

        }

        function registrarAsistenciaEmpleado(data, url='{{route('tienda.empleados.asistencia')}}') {

            $.ajax({
                url:url,
                data:data,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:"POST",
                success:function(data)
                {
                    $("#asistenciaModal").modal("hide");
                    //console.log(data);
                    if (data.ok) {
                        if (data.entrada) {
                            mostrarExitoso("La entrada fue registrada correctamente.");
                        }else{
                            mostrarExitoso("La salida fue registrada correctamente.");
                        }
                    }else{
                        mostrarError("Hubo un error al realizarl el registro, vuelve a intentarlo.");
                    }

                    //$("#empleados").html(data);
                },
                error:function (error) {
                    console.log(error);
                }
            });

        }

        function mostrarExitoso(mensaje) {
            $("#mensajeExitoso").removeClass("d-none");
            $("#mensajeExitoso").html(mensaje);
            setTimeout(()=>{$("#mensajeExitoso").addClass("d-none");},10000);
        }

        function mostrarError(mensaje) {
            $("#mensajeError").removeClass("d-none");
            $("#mensajeError").html(mensaje);
            setTimeout(()=>{$("#mensajeError").addClass("d-none");},30000);
        }

        let loader = `<div class="d-flex justify-content-center">
                <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>`;

        function filtrar($event, items) {
            items.addClass('d-none').filter(function (item)
            {
                return ($(this)[0].dataset.nombre.toLowerCase().includes($($event.target).val().toLowerCase())) | ($(this)[0].dataset.codigo.includes($($event.target).val().toLowerCase()));
            }).removeClass('d-none');
        }

        $(document).ready(function () {

            $("a.asistenciaEmpleado").on("click",function (ev) {
                ev.preventDefault();

                $("#empleados").empty();
                $(loader).clone().appendTo($("#empleados"));

                fetch_data();
            });

            $("#botonFormAsociarProveedor").on("click",function (ev) {
                ev.preventDefault();

                // $("#productos").empty();
                // $(loader).clone().appendTo($("#productos"));

                let data = FDtoJSON(new FormData($("#formAsosciar")[0]))
                //console.log(data);
                fetch_data(data,'{{route('proveedores.asociarProductos')}}');
                $("#asociarModal").modal('hide');
            });

            $('#filtro').on('keyup change',function ($event) {
                var items = $('#productos div.form-group');
                filtrar($event, items);
            });

            $(document).on('click','.empleado',function (ev) {

                $(this).toggleClass('active');
                let data = $(this).data();
                registrarAsistenciaEmpleado(data);

            })
        });

    </script>

@endsection
