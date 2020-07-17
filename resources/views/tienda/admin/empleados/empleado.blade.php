@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Datos de empleado') }}</span>
                    <a href="{{route('tienda.admin.empleados')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir a empleados
                    </a>
                </div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success" role="alert" id="mensajeExito">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="container-fluid">

                        <div class="row">

                            <div class="col-12 col-md-6 align-self-center">

                                <article class="media border rounded p-2">

                                    <img src="{{url('img/usuarios/usuario_default.png')}}" alt="" width="90" class="align-self-center px-2">

                                    <div class="media-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item h4">{{$empleado->usuario->persona->nombreCompleto}}</li>
                                            <li class="list-group-item"> {{$empleado->usuario->email}}</li>
                                            <li class="list-group-item"> {{$empleado->usuario->persona->telefono}}</li>
                                        </ul>
                                    </div>

                                </article>

                            </div>

                            <div class="col-12 col-md-6 align-self-center py-3">

                                <form class="row justify-content-end" action="{{route('tienda.admin.empleados.editar',$empleado->id)}}" method="POST">

                                    @csrf

                                    <div class="form-group col-md-12">
                                        <label for="">Fecha de ingreso a la tienda:</label>
                                        <span class="h5">{{$empleado->inicioFechaCompleta}}</span>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="">Forma de pago:</label>
                                        <select name="formapago" id="formapago" class="form-control">
                                            <option value="1" {{$empleado->formaPago == 'diario'?"selected":""}}>Diario</option>
                                            <option value="2" {{$empleado->formaPago == 'semanal'?"selected":""}}>Semanal</option>
                                            <option value="3" {{$empleado->formaPago == 'quincenal'?"selected":""}}>Quincenal</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="">Sueldo:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" name="sueldo" id="sueldo" class="form-control" value="{{$empleado->sueldo}}" required>
                                        </div>
                                    </div>

                                    <div class="form-group col-6 my-0">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>

                                </form>

                            </div>

                        </div>

                        <h2 class="mt-3">Asistencias</h2>

                        <div class="row">

                            <div class="col-12 align-self-center py-3">

                                <div class="form-inline">

                                    <select name="mesAsistencias" id="mesAsistencias" class="form-control mx-1">
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


                                    <select name="anioAsistencias" id="anioAsistencias" class="form-control mx-1">
                                        @foreach ($anios as $a)
                                            <option value="{{$a}}" {{$anio==$a?"selected":""}}>{{$a}}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="row justify-content-center" id="asistencias">

                            @include('tienda.admin.empleados.asistencias')

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

    let loader = `<div class="d-flex justify-content-center">
        <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>`;

    function fetch_asistencias(mes, anio, url="{{route('tienda.admin.empleados.ver.asistencias',$empleado->id)}}") {
        $("#asistencias").empty();
        $(loader).appendTo("#asistencias");

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
                $("#asistencias").empty();
                $("#asistencias").html(data);
            },
            error:function (error) {
                console.log(error);
            }
        })
    }

    $(document).ready(function (ev) {

        setTimeout(() => {
            $("#mensajeExito").addClass('d-none');
        }, 20000);

        $('#anioAsistencias, #mesAsistencias').change(function (ev) {
            console.log(ev);

            let mes = $("#mesAsistencias").val();
            let anio = $("#anioAsistencias").val();

            fetch_asistencias(mes, anio);
        });

    })
</script>
@endsection
