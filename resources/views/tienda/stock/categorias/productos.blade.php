
@forelse ($productos as $producto)
    <div class="form-group" data-nombre="{{$producto->producto}}" data-codigo="{{$producto->codigo}}">
        <div class="custom-control custom-switch">
            <input type="checkbox" name="prod-{{$producto->id}}" id="prod-{{$producto->id}}" class="custom-control-input" @if ($producto->categorias->contains($categoria)) checked @endif>
            <label for="prod-{{$producto->id}}" class="custom-control-label">
                <img src="{{url('img/productos/'.$producto->imagen)}}" alt="" style="max-width: 30px; max-height: 30px;">
                {{$producto->producto}} {{$producto->tamano}} {{$producto->unidadMedida}}
            </label>
        </div>
        {{-- <input type="checkbox" name="prod-{{$producto->id}}" id="prod-{{$producto->id}}" class="custom-control-input">
        <label for="prod-{{$producto->id}}">{{$producto->producto}} {{$producto->tamano}} {{$producto->unidadMedida}}</label> --}}
    </div>
@empty

@endforelse
