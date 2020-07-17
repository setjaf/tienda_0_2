@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Marcas') }}</span>
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
                    <div class="row justify-content-center my-auto">

                        <div class="col-12 text-center row justify-content-center">
                            <div class="col-md-4">
                                <a href="#" class="text-secondary nuevaMarca" data-toggle="modal" data-target="#marcaModal">
                                    <div class="p-3 text-center">
                                        <i class="material-icons" style="font-size: 70px">add_box</i>
                                        <p>Agregar marca</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 row overflow-auto lista-producto" style="max-height:500px;">

                        @forelse ($marcas as $marca)
                            <div class="col-md-6 my-2 marca">
                                <div class="card mx-auto d-flex">

                                    <div class="row no-gutters">

                                        <div class="col-4 overflow-hidden d-flex p-3">
                                            <img src="{{url('img/marcas/'.$marca->imagen)}}" alt="No se encontró la imagen" class="mw-100 mh-100 m-auto">
                                        </div>

                                        <div class="col-8">
                                            <div class="card-body">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{$marca->marca}}</h5>
                                                    {{-- <small>{{$marca->id}}</small> --}}
                                                </div>
                                                {{-- <p class="card-text">{{$marca->descripcion}}</p> --}}
                                                <a href="#" class="btn btn-link editarMarca" data-toggle="modal" data-target="#marcaModal"
                                                    data-marca='{{$marca->marca}}'
                                                    data-idmarca='{{$marca->id}}'
                                                    data-descripcion='{{$marca->descripcion}}'
                                                    data-activo='{{$marca->activo?1:0}}'
                                                    data-imagen='{{$marca->imagen}}'
                                                >Editar marca</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @empty
                        <div class="col-12 my-2">
                            <span class="h4">No hay marcas registradas</span>
                        </div>
                        @endforelse

                        </div>

                        {{-- <div class="w-100"></div>

                        {{$marcas->links()}} --}}

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('modales')

<div class="modal fade" id="marcaModal" tabindex="-1" role="dialog" aria-labelledby="marcaModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMarca" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="marca" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" name="marca">
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="col-form-label">Descripción:</label>
                        <textarea class="form-control" name="descripcion"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="activo" id="activo" checked>
                            <label class="custom-control-label" for="activo">Activo</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tamano">Imagen:</label>
                        <div class="text-center overflow-hidden">
                            <img id="imagenMarca" class="mw-100">
                        </div>
                        <input type="file" name="imagen" id="imagen" placeholder="0.00" class="form-control">
                        <div class="custom-control custom-switch" id="divEliminarImagen">
                            <input type="checkbox" class="custom-control-input" name="eliminarImagen" id="eliminarImagen">
                            <label class="custom-control-label" for="eliminarImagen">Eliminar imagen</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarMarca">Delete</button> --}}
                <button type="button" class="btn btn-primary" id="botonFormMarca"></button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script>

        function llenarModal(dataset) {
            var frm = $("#formMarca");
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
                    $('#imagenMarca').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }else{
                $('#imagenMarca').attr('src', '');
            }
        }

        $(document).ready(function () {
            $("a.editarMarca").on("click",function (ev) {
                ev.preventDefault();
                $("#botonEliminarMarca").show();
                $("#divEliminarImagen").show();
                $("#formMarca")[0].action = '{{url('tienda/stock/marcas/editar')}}'+'/'+$(this)[0].dataset.idmarca;
                $("#botonFormMarca").text("Guardar marca");
                $('#imagenMarca').attr('src','{{url('img/marcas/')}}'+'/'+$(this)[0].dataset.imagen);
                $('#formMarca').trigger("reset");
                llenarModal($(this)[0].dataset);
            });

            $("a.nuevaMarca").on("click",function (ev) {
                ev.preventDefault();
                $("#botonEliminarMarca").hide();
                $("#divEliminarImagen").hide();
                $("#formMarca")[0].action = '{{route('stock.nuevaMarca')}}';
                $("#botonFormMarca").text("Agregar marca");
                $('#formMarca').trigger("reset");
            });

            $("#botonFormMarca").on("click", function (ev) {

                console.log($("#formMarca"));

                $("#formMarca").submit();

            })

            $("#botonEliminarMarca").on("click", function (ev) {

                if(confirm("¿Estás seguro que quieres eliminar la marca?")){

                    $("#formMarca")[0].action = '{{url('tienda/stock/marcas/editar')}}'+'/'+$(this)[0].dataset.idmarca;

                    console.log($("#formMarca"));

                    $("#formMarca").submit();

                }

            });

            $("#imagen").change(function() {
                readURL(this);
            });
        });


    </script>

@endsection
