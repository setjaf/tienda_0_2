@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Categorias') }}</div>

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
                            <div class="col-md-4">
                                <a href="#" class="text-secondary nuevaCategoria" data-toggle="modal" data-target="#categoriaModal">
                                    <div class="p-5 text-center">
                                        <i class="material-icons" style="font-size: 70px">add_box</i>
                                        <p>Agregar categoria</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 row overflow-auto lista-producto" style="max-height:500px;">
                        @unless (empty($categorias))
                            @foreach ($categorias as $categoria)
                            <div class="col-md-4 my-2 categoria">
                                <div class="card mx-auto d-flex" @if ($categoria->color != null) style='border-top: 5px solid {{$categoria->color}};' @endif>

                                    <div class="row no-gutters">

                                        {{-- <div class="col-4 overflow-hidden d-flex">
                                            <img src="{{url('img/categorias/'.$categoria->imagen)}}" alt="No se encontró la imagen" class="mw-100 mh-100 m-auto">
                                        </div> --}}

                                        <div class="col-12">
                                            <div class="card-body">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{$categoria->categoria}}</h5>
                                                    {{-- <small>{{$categoria->id}}</small> --}}
                                                </div>
                                                {{-- <p class="card-text">{{$categoria->descripcion}}</p> --}}
                                                <a href="#" class="btn btn-link editarCategoria" data-toggle="modal" data-target="#categoriaModal"
                                                    data-categoria='{{$categoria->categoria}}'
                                                    data-idcategoria='{{$categoria->id}}'
                                                    data-descripcion='{{$categoria->descripcion}}'
                                                    data-activo='{{$categoria->activo?1:0}}'
                                                    data-color='{{$categoria->color}}'
                                                >Editar categoria</a>

                                                <a href="#" class="btn btn-link asociarCategoria" data-toggle="modal" data-target="#asociarModal"
                                                    data-categoria='{{$categoria->categoria}}'
                                                    data-idcategoria='{{$categoria->id}}'
                                                    data-descripcion='{{$categoria->descripcion}}'
                                                    data-activo='{{$categoria->activo?1:0}}'
                                                    data-color='{{$categoria->color}}'
                                                >Asociar Productos</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            @endforeach
                            </div>

                            <div class="w-100"></div>

                            {{$categorias->links()}}
                        @else
                        <div class="col-12 my-2">
                            <span class="">No hay categorias registradas</span>
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

<div class="modal fade" id="categoriaModal" tabindex="-1" role="dialog" aria-labelledby="categoriaModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCategoria" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="categoria" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" name="categoria">
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
                        <label for="color">Color:</label>
                        <div class="col-md-6">
                            <input type="hidden" name="color" value="" id="color">
                            <div class="dropdown">
                                <button type="button" class="form-control dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons" style="color:#FFFFFF;vertical-align: bottom;">label</i>
                                </button>
                                <div id="colores" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 0rem !important; max-height:250px; overflow:auto;">
                                    <button type="button" class="dropdown-item" data-color=""><i class="material-icons" style="color:#FFFFFF;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#C0C0C0"><i class="material-icons" style="color:#C0C0C0;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#808080"><i class="material-icons" style="color:#808080;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#000000"><i class="material-icons" style="color:#000000;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#FF0000"><i class="material-icons" style="color:#FF0000;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#800000"><i class="material-icons" style="color:#800000;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#FFFF00"><i class="material-icons" style="color:#FFFF00;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#808000"><i class="material-icons" style="color:#808000;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#00FF00"><i class="material-icons" style="color:#00FF00;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#008000"><i class="material-icons" style="color:#008000;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#00FFFF"><i class="material-icons" style="color:#00FFFF;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#008080"><i class="material-icons" style="color:#008080;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#0000FF"><i class="material-icons" style="color:#0000FF;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#000080"><i class="material-icons" style="color:#000080;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#FF00FF"><i class="material-icons" style="color:#FF00FF;vertical-align:bottom;">label</i></button>
                                    <button type="button" class="dropdown-item" data-color="#800080"><i class="material-icons" style="color:#800080;vertical-align:bottom;">label</i></button>
                                </div>
                            </div>
                            @error('unidadMedida')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarCategoria">Delete</button> --}}
                <button type="button" class="btn btn-primary" id="botonFormCategoria"></button>
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
                    <span id="categoriaNombre"></span>
                    (<i class="material-icons" style="color:#000000;vertical-align:middle;" id="colorAsociar">label</i>)
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
                    <input type="hidden" name="categoria" id="idcategoria">
                    <div id="productos" style="max-height: 50vh; overflow: auto;">

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarCategoria">Delete</button> --}}
                <button type="button" class="btn btn-primary" id="botonFormAsociarCategoria">Guardar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script>
        function FDtoJSON(FormData) {
            let object = {};
            object['productos'] = [];
            FormData.forEach(
                (value,key)=>{
                    if (key.includes("prod-")) {
                        object['productos'].push(key.split('prod-')[1]);
                    }else if(value!=''){
                        object[key]=value;
                    }
                }
            );
            return object;
        }

        function llenarModal(dataset) {
            var frm = $("#formCategoria");
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

        function setColor(color = null) {
            if (color) {
                $("#dropdownMenuLink").empty();
                $(`<i class="material-icons" style="color:${color};vertical-align: bottom;">label</i>`).clone().appendTo($("#dropdownMenuLink"));
                $("#color").val(color);
            }else{
                $("#dropdownMenuLink").empty();
                $(`<i class="material-icons" style="color:#FFFFFF;vertical-align: bottom;">label</i>`).clone().appendTo($("#dropdownMenuLink"));
                $("#color").val(color);
            }
        }

        function fetch_data(data,url='{{route('stock.showCategoriasProductos')}}') {

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
            $("#colores button.dropdown-item").on("click",function (ev) {
                ev.preventDefault();

                if(ev.target != this){
                    setColor(ev.target.parentElement.dataset.color);
                    //$("#dropdownMenuLink").empty();
                    //$(ev.target).clone().appendTo($("#dropdownMenuLink"));
                    //$("#color").val(ev.target.parentElement.dataset.color);
                    //console.log(ev.target.parentElement.dataset.color);

                }else{
                    setColor(ev.target.dataset.color);
                    //$("#dropdownMenuLink").empty();
                    //$(ev.target.firstChild).clone().appendTo($("#dropdownMenuLink"));
                    //$("#color").val(ev.target.dataset.color);
                    //console.log(ev.target.dataset.color);
                }

            });
            $("a.editarCategoria").on("click",function (ev) {
                ev.preventDefault();
                $("#botonEliminarCategoria").show();
                $("#divEliminarImagen").show();
                $("#formCategoria")[0].action = '{{url('tienda/stock/categorias/editar')}}'+'/'+$(this)[0].dataset.idcategoria;
                $("#botonFormCategoria").text("Guardar categoria");
                setColor($(this)[0].dataset.color);
                $('#formCategoria').trigger("reset");
                llenarModal($(this)[0].dataset);
            });

            $("a.nuevaCategoria").on("click",function (ev) {
                ev.preventDefault();
                $("#botonEliminarCategoria").hide();
                $("#divEliminarImagen").hide();
                $("#formCategoria")[0].action = '{{route('stock.nuevaCategoria')}}';
                $("#botonFormCategoria").text("Agregar categoria");
                setColor(null);
                $('#formCategoria').trigger("reset");
            });

            $("#botonFormCategoria").on("click", function (ev) {

                console.log($("#formCategoria"));

                $("#formCategoria").submit();

            })

            $("#botonEliminarCategoria").on("click", function (ev) {

                if(confirm("¿Estás seguro que quieres eliminar la categoria?")){

                    $("#formCategoria")[0].action = '{{url('tienda/stock/categorias/editar')}}'+'/'+$(this)[0].dataset.idcategoria;

                    console.log($("#formCategoria"));

                    $("#formCategoria").submit();

                }

            });

            $("a.asociarCategoria").on("click",function (ev) {
                ev.preventDefault();

                $("#productos").empty();
                $(loader).clone().appendTo($("#productos"));

                $("#colorAsociar").css('color',$(this)[0].dataset.color);
                $("#categoriaNombre").html($(this)[0].dataset.categoria);
                $("#idcategoria").val($(this)[0].dataset.idcategoria);
                let data = {categoria:$(this)[0].dataset.idcategoria}
                fetch_data(data);
            });

            $("#botonFormAsociarCategoria").on("click",function (ev) {
                ev.preventDefault();

                // $("#productos").empty();
                // $(loader).clone().appendTo($("#productos"));

                let data = FDtoJSON(new FormData($("#formAsosciar")[0]))
                fetch_data(data,'{{route('stock.categoriaAsociarProductos')}}');
                $("#asociarModal").modal('hide');
            });

            $('#filtro').on('keyup change',function ($event) {
                var items = $('#productos div.form-group');
                console.log(items);
                filtrar($event, items);
            });
        });




    </script>

@endsection
