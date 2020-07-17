@foreach ($productos as $producto)
<li class="list-group-item w-100 producto container" style="height: 60px;"
                data-producto="{{$producto->producto}}"
                data-codigo="{{$producto->codigo}}"
                data-id="{{$producto->id}}"
                data-unidadMedida="{{$producto->unidadMedida}}"
                data-tamano="{{$producto->tamano}}"
                data-precioVenta="{{$producto->precioVenta}}"
                data-imagen="{{url('img/productos/'.$producto->imagen)}}"
>
    <div class="row h-100">
        <div class="col-2 h-100">
            <img src="{{url('img/productos/'.$producto->imagen)}}" alt="" class="mw-100 mh-100 m-auto">
        </div>
        <div class="col-10 m-auto">
            {{$producto->producto}} {{$producto->tamano}}{{$producto->unidadMedida}}
        </div>
    </div>
</li>
@endforeach

