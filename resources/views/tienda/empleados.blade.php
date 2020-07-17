<div class="h4">Registrar entrada</div>
<ul class="list-group">

@forelse ($empleadosEntrada as $empleado)
    <li class="list-group-item list-group-item-action col-12 empleado" style="height: 60px;"
        data-idempleado="{{$empleado->pivot->id}}"
        data-entrada="1">
        <div class="row h-100">
            <div class="col-2 h-100">
                <img src="{{url('img/usuarios/'.$empleado->imagen)}}" alt="" class="mw-100 mh-100 m-auto">
            </div>
            <div class="col-10 m-auto">
                {{$empleado->persona->nombreCompleto}}
            </div>
        </div>
    </li>
@empty
    <li class="list-group-item list-group-item-action col-12" style="height: 60px;">
        <div class="row h-100">
            <div class="col m-auto">
                No hay empleados para registrar entrada.
            </div>
        </div>
    </li>
@endforelse
</ul>

<div class="h4 mt-2">Registrar salida</div>
<ul class="list-group">

    @forelse ($empleadosSalida as $empleado)
    <li class="list-group-item list-group-item-action col-12 empleado" style="height: 60px;"
        data-idempleado="{{$empleado->pivot->id}}"
        data-entrada="0">
        <div class="row h-100">
            <div class="col-2 h-100">
                <img src="{{url('img/usuarios/'.$empleado->imagen)}}" alt="" class="mw-100 mh-100 m-auto">
            </div>
            <div class="col-10 m-auto">
                {{$empleado->persona->nombreCompleto}}
            </div>
        </div>
    </li>
    @empty
    <li class="list-group-item list-group-item-action col-12" style="height: 60px;">
        <div class="row h-100">
            <div class="col m-auto">
                No hay empleados para registrar entrada.
            </div>
        </div>
    </li>
    @endforelse
</ul>
