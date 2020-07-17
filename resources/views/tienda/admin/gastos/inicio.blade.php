@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Gastos') }}</span>
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
                                        <a href="#" id="nuevoGasto" class=" text-secondary nuevoTipoGasto stretched-link" data-toggle="modal" data-target="#gastoModal">
                                            <p>Agregar gasto</p>
                                        </a>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="p-3 text-center text-secondary">
                                        <i class="material-icons" style="font-size: 70px">class</i>
                                        <a href="{{route('tienda.admin.gastos.tipos')}}" class=" text-secondary nuevoTipoGasto stretched-link">
                                            <p>Agregar tipo de gasto</p>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-12 align-self-center py-3">

                                <div class="form-inline">

                                    <select name="mesGastos" id="mesGastos" class="form-control mx-1">
                                        <option value="1" {{$mes==1?"selected":""}}>Enero</option>
                                        <option value="2" {{$mes==2?"selected":""}}>Febrero</option>
                                        <option value="3" {{$mes==3?"selected":""}}>Marzo</option>
                                        <option value="4" {{$mes==4?"selected":""}}>Abril</option>
                                        <option value="5" {{$mes==5?"selected":""}}>Mayo</option>
                                        <option value="6" {{$mes==6?"selected":""}}>Junio</option>
                                        <option value="7" {{$mes==7?"selected":""}}>Julio</option>
                                        <option value="8" {{$mes==8?"selected":""}}>Agosto</option>
                                        <option value="9" {{$mes==9?"selected":""}}>Septiembre</option>
                                        <option value="10" {{$mes==10?"selected":""}}>Octubre</option>
                                        <option value="11" {{$mes==11?"selected":""}}>Noviembre</option>
                                        <option value="12" {{$mes==12?"selected":""}}>Diciembre</option>
                                    </select>


                                    <select name="anioGastos" id="anioGastos" class="form-control mx-1">
                                        @foreach ($anios as $a)
                                            <option value="{{$a}}" {{$anio==$a?"selected":""}}>{{$a}}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="row justify-content-center" id="gastos">

                            @include('tienda.admin.gastos.gastos')

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('modales')

<div class="modal fade" id="gastoModal" tabindex="-1" role="dialog" aria-labelledby="gastoModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo gasto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formGasto" action="{{route('tienda.admin.gastos.nuevo')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="">Tipo de gasto:</label>
                        <select name="idtipogasto" id="idtipogasto" class="form-control" required>
                            @include('tienda.admin.gastos.tiposGastoSelect')
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="importe" class="col-form-label">Importe:</label>
                        <input type="number" class="form-control" name="importe" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion" class="col-form-label">Descripción:</label>
                        <textarea class="form-control" name="descripcion"></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" id="botonEliminarGasto">Delete</button> --}}
                <button type="submit" class="btn btn-primary" form="formGasto" id="botonFormTipoGasto">Guardar</button>
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
            var frm = $("#formGasto");
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

        let loader = `<div class="d-flex justify-content-center">
            <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>`;

        function fetch_gastos(mes, anio, url="{{route('tienda.admin.gastos.ver')}}") {
            $("#gastos").empty();
            $(loader).appendTo("#gastos");

            $.ajax({
                url:url,
                data:{mes:mes, anio:anio},
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:"POST",
                success:function(data)
                {
                    console.log(data);
                    $("#gastos").empty();
                    $("#gastos").html(data);
                },
                error:function (error) {
                    console.log(error);
                }
            })
        }

        $(document).ready(function () {

            $(document).on("click",".editarGasto",function (ev) {
                ev.preventDefault();
                $("#botonGuardar").attr('formaction','{{url('tienda/admin/gastos')}}'+'/'+$(this).data().id);
                $('#formGasto').trigger("reset");
                console.log($(this).data());

                llenarModal($(this).data());
            });

            $("#nuevoGasto").click(function () {
                $("#botonGuardar").removeAttr('formaction');
                $('#formGasto').trigger("reset");
            });

            $('#anioGastos, #mesGastos').change(function (ev) {
                console.log(ev);

                let mes = $("#mesGastos").val();
                let anio = $("#anioGastos").val();

                fetch_gastos(mes, anio);
            });
        });

    </script>

@endsection
