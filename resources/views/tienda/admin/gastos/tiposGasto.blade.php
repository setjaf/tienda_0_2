@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Tipo de gastos') }}</span>
                    <a href="{{route('tienda.admin.gastos')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir a gastos
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
                    <div class="container-fuid">
                        <div class="row justify-content-center my-auto">

                            <div class="col-12 text-center row justify-content-center">

                                <div class="col-md-4">

                                    <div class="p-3 text-center text-secondary">
                                        <i class="material-icons" style="font-size: 70px">add_box</i>
                                        <a href="#" id="nuevoTipo" class="text-secondary nuevoTipoGasto stretched-link" data-toggle="modal" data-target="#tipoGastoModal">
                                            <p>Agregar tipo gasto</p>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="row justify-content-center">

                            @forelse ($tiposGasto as $tipoGasto)
                            <div class="col-12 col-md-4 p-2">
                                <div class="d-flex justify-content-between align-center border rounded p-2" style="border-top:{{$tipoGasto->color}} solid 5px !important;">
                                    <div class="mt-2">
                                        <span class="h5 align-self-center">{{$tipoGasto->nombre}}</span>
                                        <p class="py-2 m-0"><small>{{$tipoGasto->descripcion}}</small></p>
                                        <a href="#" class="editarTipo" data-toggle="modal" data-target="#tipoGastoModal"
                                            data-id="{{$tipoGasto->id}}"
                                            data-nombre="{{$tipoGasto->nombre}}"
                                            data-descripcion="{{$tipoGasto->descripcion}}"
                                            data-color="{{$tipoGasto->color}}"
                                        >Editar tipo gasto</a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 col-md-12">
                                <div class="d-flex justify-content-between align-center p-4 text-center border rounded">
                                    <span class="align-self-center">No hay tipos de gasto registrados.</span>
                                </div>
                            </div>
                            @endforelse


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('modales')

<div class="modal fade" id="tipoGastoModal" tabindex="-1" role="dialog" aria-labelledby="tipoGastoModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo tipo de gasto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formGasto" action="{{route('tienda.admin.gastos.tipos.nuevo')}}" method="POST" enctype="multipart/form-data" class="row">
                    @csrf
                    <div class="form-group col-md-6">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" name="nombre">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="color">Color:</label>
                        <div class="col-md-6">
                            <input type="hidden" name="color" value="#FFFFFF" id="color">
                            <div class="dropdown">
                                <button type="button" class="form-control dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons" style="color:#FFFFFF;vertical-align: bottom;">label</i>
                                </button>
                                <div id="colores" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 0rem !important; max-height:250px; overflow:auto;">
                                    <button type="button" class="dropdown-item" data-color="#FFFFFF"><i class="material-icons" style="color:#FFFFFF;vertical-align:bottom;">label</i></button>
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
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="descripcion" class="col-form-label">Descripción:</label>
                        <textarea class="form-control" name="descripcion"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="botonGuardar" form="formGasto" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function setColor(color = null) {
        if (color) {
            $("#dropdownMenuLink").empty();
            $(`<i class="material-icons" style="color:${color};vertical-align: bottom;">label</i>`).clone().appendTo($("#dropdownMenuLink"));
            $("#color").val(color);
        }else{
            $("#dropdownMenuLink").empty();
            $(`<i class="material-icons" style="color:#FFFFFF;vertical-align: bottom;">label</i>`).clone().appendTo($("#dropdownMenuLink"));
            $("#color").val('#FFFFFF');
        }
    }

    function llenarModal(dataset) {
        var frm = $("#formGasto");
        var campo;
        //console.log(dataset);
        for (campo in dataset) {

            //console.log(frm.find('[name="' + campo + '"]'));

            if (frm.find('[name="' + campo + '"]')[0] != null) {
                //console.log(frm.find('[name="' + campo + '"]')[0].type);

                switch (frm.find('[name="' + campo + '"]')[0].type) {
                    case 'checkbox':
                        //console.log(dataset[campo]);
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

        $("a.editarTipo").on("click",function (ev) {
            ev.preventDefault();
            $("#botonGuardar").attr('formaction','{{url('tienda/admin/gastos/tipos')}}'+'/'+$(this).data().id);
            $('#formGasto').trigger("reset");
            setColor($(this).data().color);
            llenarModal($(this).data());
        });

        $("#nuevoTipo").click(function () {
            $("#botonGuardar").removeAttr('formaction');
            $('#formGasto').trigger("reset");
            setColor();
        })


    });
</script>
@endsection
