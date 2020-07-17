@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Empleados') }}</span>
                    <a href="{{route('tienda.admin')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir a administración
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
                            <div class="col-md-4">
                                <a href="#" id="nuevoEmpleado" class="text-secondary nuevoEmpleado" data-toggle="modal" data-target="#asociarModal">
                                    <div class="p-3 text-center">
                                        <i class="material-icons" style="font-size: 70px">add_box</i>
                                        <p>Agregar empleado</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 row overflow-auto lista-empleado" style="max-height:500px;">
                        @unless (empty($empleados))
                            @foreach ($empleados as $empleado)
                            <div class="col-md-6 my-2 empleado">
                                <div class="card mx-auto d-flex">

                                    <div class="row no-gutters">

                                        <div class="col-4 overflow-hidden d-flex p-3">
                                            <img src="{{url('img/usuarios/'.$empleado->imagen)}}" alt="No se encontró la imagen" class="mw-100 mh-100 m-auto">
                                        </div>

                                        <div class="col-8">
                                            <div class="card-body">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{$empleado->persona->nombreCompleto}}</h5>
                                                    <small>${{$empleado->trabajaEn()->find($tiendaLog->id)->pivot->sueldo}}</small>
                                                </div>
                                                {{-- <p class="card-text">{{$empleado->descripcion}}</p> --}}
                                                <a href="{{route('tienda.admin.empleados.ver',$empleado->pivot->id)}}" class="btn btn-link stretched-link">
                                                    Ver empleado
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            @endforeach
                            </div>

                            <div class="w-100"></div>

                            {{-- {{$empleados->links()}} --}}
                        @else
                        <div class="col-12 my-2">
                            <span class="display-4">No hay empleados registrados</span>
                        </div>
                        @endunless

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('modales')

<div class="modal fade" id="asociarModal" tabindex="-1" role="dialog" aria-labelledby="asociarModal" aria-hidden="true">
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
                <div class="form-group col-12">
                    <label for="filtro">Buscar por nombre o correo electrónico</label>
                    <input type="text" id="filtro" class="form-control"/>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="formAsosciar">
                    <input type="hidden" name="categoria" id="idcategoria">

                    <div id="empleados" style="max-height: 50vh; overflow: auto;">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarCategoria">Delete</button> --}}
                <button type="button" class="btn btn-primary" id="botonFormAsociarEmpleado">Guardar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script>

        function FDtoJSON(FormData) {
            let object = {};
            object['empleados'] = {};
            FormData.forEach(
                (value,key)=>{
                    if (key.includes("emp-")) {
                        object['empleados'][key.split('emp-')[1]] = {sueldo:0, formapago:1};
                    }else if (key.includes("sueldo-")) {
                        if (object['empleados'].hasOwnProperty(key.split('sueldo-')[1])) {
                            object['empleados'][key.split('sueldo-')[1]]['sueldo']=value;
                        }
                    }else if (key.includes("formapago-")) {
                        if (object['empleados'].hasOwnProperty(key.split('formapago-')[1])) {
                            object['empleados'][key.split('formapago-')[1]]['formapago']=value;
                        }
                    }else if(value!=''){
                        object[key]=value;
                    }
                }
            );
            return object;
        }

        function fetch_data(url='{{route('tienda.admin.empleados.fetch')}}') {

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

        let loader = `<div class="d-flex justify-content-center">
            <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>`;

        function filtrar($event, items) {
            items.addClass('d-none').filter(function (item)
            {
                return ($(this)[0].dataset.nombre.toLowerCase().includes($($event.target).val().toLowerCase())) | ($(this)[0].dataset.email.includes($($event.target).val().toLowerCase()));
            }).removeClass('d-none');
        }

        function llenarModal(dataset) {
            var frm = $("#formEmpleado");
            var campo;
            //console.log(dataset);
            for (campo in dataset) {

                //console.log(frm.find('[name="' + campo + '"]'));

                if (frm.find('[name="' + campo + '"]')[0] != null) {

                    switch (frm.find('[name="' + campo + '"]')[0].type) {
                        case 'checkbox':
                            if (dataset[campo] == "0")
                                frm.find('[name="' + campo + '"]')[0].checked=false;
                            break;

                        default:
                            frm.find('[name="' + campo + '"]').val(dataset[campo]);
                            break;
                    }

                }

                //frm.find('[name="' + campo + '"]').val(dataset[campo]);
            }
        }

        function readURL(input) {
            console.log(input);

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imagenEmpleado').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }else{
                $('#imagenEmpleado').attr('src', '');
            }
        }

        function asociarEmpleados(data, url='{{route('tienda.admin.empleados.asociar')}}') {

            $.ajax({
                url:url,
                data:data,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:"POST",
                success:function(data)
                {
                    //console.log(data);
                    location.reload();
                },
                error:function (error) {
                    console.log(error);
                }

            });

        }

        $(document).ready(function () {
            $("a.editarEmpleado").on("click",function (ev) {
                ev.preventDefault();
                $("#botonEliminarEmpleado").show();
                $("#divEliminarImagen").show();
                $("#formEmpleado")[0].action = '{{url('tienda/stock/empleados/editar')}}'+'/'+$(this)[0].dataset.idempleado;
                $("#botonFormEmpleado").text("Guardar empleado");
                $('#imagenEmpleado').attr('src','{{url('img/empleados/')}}'+'/'+$(this)[0].dataset.imagen);
                $('#formEmpleado').trigger("reset");
                llenarModal($(this)[0].dataset);
            });

            // $("a.nuevoEmpleado").on("click",function (ev) {
            //     ev.preventDefault();
            //     $("#botonEliminarEmpleado").hide();
            //     $("#divEliminarImagen").hide();
            //     $("#formEmpleado")[0].action = '';
            //     $("#botonFormEmpleado").text("Agregar empleado");
            //     $('#formEmpleado').trigger("reset");
            // });

            $("#nuevoEmpleado").on("click",function (ev) {
                ev.preventDefault();

                $("#empleados").empty();
                $(loader).clone().appendTo($("#empleados"));

                // $("#proveedorNombre").html($(this)[0].dataset.nombre);
                // $("#idproveedor").val($(this)[0].dataset.idproveedor);
                // let data = {proveedor:$(this)[0].dataset.idproveedor}
                fetch_data();
            });

            // $("#botonFormEmpleado").on("click", function (ev) {

            //     console.log($("#formEmpleado"));

            //     $("#formEmpleado").submit();

            // })

            // $("#botonEliminarEmpleado").on("click", function (ev) {

            //     if(confirm("¿Estás seguro que quieres eliminar la empleado?")){

            //         $("#formEmpleado")[0].action = '{{url('tienda/stock/empleados/editar')}}'+'/'+$(this)[0].dataset.idempleado;

            //         console.log($("#formEmpleado"));

            //         $("#formEmpleado").submit();

            //     }

            // });

            $("#botonFormAsociarEmpleado").on("click",function (ev) {
                ev.preventDefault();

                // $("#productos").empty();
                // $(loader).clone().appendTo($("#productos"));

                let data = FDtoJSON(new FormData($("#formAsosciar")[0]))
                console.log(data);
                asociarEmpleados(data);
                //$("#asociarModal").modal('hide');
            });

            $('#filtro').on('keyup change',function ($event) {
                var items = $('#empleados div.form-group');
                filtrar($event, items);
            });


        });


    </script>

@endsection
