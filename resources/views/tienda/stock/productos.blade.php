
@forelse ($stock as $producto)
<div class="col-md-6 my-2 producto"
    data-nombre='{{$producto->producto}}'
    data-codigo='{{$producto->id}}'
>
    <div class="card mx-auto d-flex
    @if (($producto->disponible - $producto->deseado) < 0)
        border-danger
    @endif
    @if (($producto->disponible - $producto->deseado) == 0)
        border-warning
    @endif
    ">

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
                            {{$producto->disponible}} @if ($producto->formaVenta == 'granel')
                                {{$producto->unidadMedida}}
                            @else
                                {{'piezas'}}
                            @endif
                        </li>
                        <li class="list-group-item">${{$producto->precioVenta}}</li>
                    </ul>
                    {{-- <p class="card-text">{{$producto->cantidadDisponible}}</p>
                    <p class="card-text text-muted">{{$producto->id}}</p> --}}
                    <a href="{{route('stock.showEditar',$producto->id)}}" class="btn btn-link">Editar producto</a>
                    <a href="{{route('stock.showProveedores',$producto->id)}}" class="btn btn-link">Ver proveedores ({{$producto->proveedores->count()}})</a>
                </div>
            </div>

        </div>

    </div>
</div>

@empty
<div class="col-12 my-2">
    <span class="h4">No hay productos registrados</span>
</div>
@endforelse

<div class="w-100"></div>

{{$stock->links()}}


