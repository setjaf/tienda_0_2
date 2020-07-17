@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Proveedores de '.$producto->producto) }}</span>
                    <a href="{{route('tienda.stock')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir al stock
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

                        <div class="col-12 text-center row justify-content-center">
                            <div class="col-md-6 my-2 producto"
                                data-nombre='{{$producto->producto}}'
                                data-codigo='{{$producto->id}}'
                            >
                                <div class="card mx-auto d-flex">

                                    <div class="row no-gutters">
                                        <div class="col-4 overflow-hidden d-flex flex-column">
                                            <div class="h-75 overflow-hidden d-flex">
                                                <img src="{{url('img/productos/'.$producto->imagen)}}" alt="No se encontró la imagen" class="mw-100 mh-100 m-auto">
                                            </div>
                                            <div class="h-25 overflow-auto d-flex align-middle">
                                                @forelse ($producto->categorias as $categoria)
                                                    <i class="material-icons" style="color:{{$categoria->color}};vertical-align:bottom;cursor:default;" title="{{$categoria->categoria}}">label</i>
                                                @empty

                                                @endforelse
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{$producto->producto}}</h5>
                                                    <small>{{$producto->tamano}} {{$producto->unidadMedida}}</small>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        {{$producto->codigo}}
                                                    </li>
                                                    <li class="list-group-item">
                                                        {{$producto->disponible}} @if ($producto->formaVenta == 'granel')
                                                            {{$producto->unidadMedida}}
                                                        @else
                                                            {{'piezas'}}
                                                        @endif
                                                    </li>
                                                    <li class="list-group-item">${{$producto->precioVenta}}</li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 row overflow-auto lista-producto" style="max-height:500px;">
                        @unless (!$producto->proveedores()->exists())
                            @foreach ($producto->proveedores as $proveedor)
                            <div class="col-md-4 my-2 proveedor">
                                <div class="card mx-auto d-flex" @if ($proveedor->color != null) style='border-top: 5px solid {{$proveedor->color}};' @endif>

                                    <div class="row no-gutters">

                                        {{-- <div class="col-4 overflow-hidden d-flex p-3">
                                            <img src="{{url('img/proveedores/'.$proveedor->imagen)}}" alt="No se encontró la imagen" class="mw-100 mh-100 m-auto">
                                        </div> --}}

                                        <div class="col-12">
                                            <div class="card-body">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{$proveedor->nombre}}</h5>
                                                    {{-- <small>{{$proveedor->id}}</small> --}}
                                                </div>
                                                {{-- <p class="card-text">{{$proveedor->descripcion}}</p> --}}
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        ${{$proveedor->pivot->precio}}
                                                    </li>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            @endforeach
                            </div>

                            <div class="w-100"></div>

                            {{-- {{$proveedores->links()}} --}}
                        @else
                        <div class="col-12 my-2">
                            <span class="">No hay proveedores registrados</span>
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

<div class="modal fade" id="proveedorModal" tabindex="-1" role="dialog" aria-labelledby="proveedorModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formProveedor" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="col-form-label">Saldo:</label>
                        <input type="number" class="form-control" name="saldo" value="0">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="activo" id="activo" checked>
                            <label class="custom-control-label" for="activo">Activo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarProveedor">Delete</button> --}}
                <button type="button" class="btn btn-primary" id="botonFormProveedor"></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="asociarModal" tabindex="-1" role="dialog" aria-labelledby="asociarModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Asociar productos a
                    <span id="proveedorNombre"></span>
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
                <form action="" method="POST" enctype="multipart/form-data" id="formAsosciar">
                    <input type="hidden" name="proveedor" id="idproveedor">
                    <div id="productos" style="max-height: 50vh; overflow: auto;">

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarProveedor">Delete</button> --}}
                <button type="button" class="btn btn-primary" id="botonFormAsociarProveedor">Guardar</button>
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

        function llenarModal(dataset) {
            var frm = $("#formProveedor");
            var campo;
            //console.log(dataset);
            for (campo in dataset) {

                //console.log(frm.find('[name="' + campo + '"]'));

                if (frm.find('[name="' + campo + '"]')[0] != null) {
                    console.log(frm.find('[name="' + campo + '"]')[0].type);

                    switch (frm.find('[name="' + campo + '"]')[0].type) {
                        case 'checkbox':
                            console.log(dataset[campo]);
                            if (dataset[campo] == "0"){
                                frm.find('[name="' + campo + '"]')[0].checked=false;
                            }
                            break;

                        default:
                            frm.find('[name="' + campo + '"]').val(dataset[campo]);
                            break;
                    }

                }

                //frm.find('[name="' + campo + '"]').val(dataset[campo]);
            }
        }

        function fetch_data(data,url='{{route('proveedores.showProveedoresProductos')}}') {

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
                    $("#productos").html(data);
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
                return ($(this)[0].dataset.nombre.toLowerCase().includes($($event.target).val().toLowerCase())) | ($(this)[0].dataset.codigo.includes($($event.target).val().toLowerCase()));
            }).removeClass('d-none');
        }

        $(document).ready(function () {

            $("a.editarProveedor").on("click",function (ev) {
                ev.preventDefault();
                $("#botonEliminarProveedor").show();
                $("#formProveedor")[0].action = '{{url('tienda/proveedores/editar')}}'+'/'+$(this)[0].dataset.idproveedor;
                $("#botonFormProveedor").text("Guardar proveedor");
                $('#formProveedor').trigger("reset");
                llenarModal($(this)[0].dataset);
            });

            $("a.nuevoProveedor").on("click",function (ev) {
                ev.preventDefault();
                $("#botonEliminarProveedor").hide();
                $("#formProveedor")[0].action = '{{route('proveedores.nuevo')}}';
                $("#botonFormProveedor").text("Agregar proveedor");
                $('#formProveedor').trigger("reset");
            });

            $("#botonFormProveedor").on("click", function (ev) {

                console.log($("#formProveedor"));

                $("#formProveedor").submit();

            })

            $("#botonEliminarProveedor").on("click", function (ev) {

                if(confirm("¿Estás seguro que quieres eliminar la proveedor?")){

                    $("#formProveedor")[0].action = '{{url('tienda/stock/proveedores/editar')}}'+'/'+$(this)[0].dataset.idproveedor;

                    console.log($("#formProveedor"));

                    $("#formProveedor").submit();

                }

            });

            $("a.asociarProveedor").on("click",function (ev) {
                ev.preventDefault();

                $("#productos").empty();
                $(loader).clone().appendTo($("#productos"));

                $("#proveedorNombre").html($(this)[0].dataset.nombre);
                $("#idproveedor").val($(this)[0].dataset.idproveedor);
                let data = {proveedor:$(this)[0].dataset.idproveedor}
                fetch_data(data);
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
        });




    </script>

@endsection
