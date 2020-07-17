@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Cierres por día') }}</span>
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
                        {{-- <div class="row justify-content-center my-auto">

                            <div class="col-12 text-center row justify-content-center">
                                <div class="col-md-4">

                                    <div class="p-3 text-center text-secondary">
                                        <i class="material-icons" style="font-size: 70px">add_box</i>
                                        <a href="#" id="nuevoGasto" class=" text-secondary nuevoTipoGasto stretched-link" data-toggle="modal" data-target="#cierreModal">
                                            <p>Agregar cierre</p>
                                        </a>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="p-3 text-center text-secondary">
                                        <i class="material-icons" style="font-size: 70px">class</i>
                                        <a href="{{route('tienda.admin.cierres.tipos')}}" class=" text-secondary nuevoTipoGasto stretched-link">
                                            <p>Agregar tipo de cierre</p>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div> --}}

                        <div class="row">

                            <div class="col-12 align-self-center py-3">

                                <div class="form-inline">

                                    <label for="">Seleciona un día:</label>
                                    <input type="date" name="diaConsultar" id="diaConsultar" class="form-control" value="{{$hoy}}" max="{{$hoy}}" min="{{$minDia}}">

                                    {{-- <select name="mesGastos" id="mesGastos" class="form-control mx-1">
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
                                    </select> --}}

                                </div>

                            </div>

                        </div>

                        <div class="row justify-content-center" id="cierres">

                            @include('tienda.admin.cierres.cierres')

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

        function fetch_cierres(dia, url="{{route('tienda.admin.cierres')}}") {
            $("#cierres").empty();
            $(loader).appendTo("#cierres");

            $.ajax({
                url:url,
                data:{dia:dia},
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:"POST",
                success:function(data)
                {
                    console.log(data);
                    $("#cierres").empty();
                    $("#cierres").html(data);
                },
                error:function (error) {
                    console.log(error);
                }
            })
        }

        $(document).ready(function () {
            $('#diaConsultar').change(function (ev) {
                //console.log(ev);

                console.log($("#diaConsultar").val());

                let dia = $("#diaConsultar").val();

                fetch_cierres(dia);
            });
        });

    </script>

@endsection
