
@forelse ($productos as $producto)
<div class="form-group" data-nombre="{{$producto->producto}}" data-codigo="{{$producto->codigo}}">
    <div class="custom-control custom-switch">
        <input type="checkbox" name="prod-{{$producto->id}}" id="prod-{{$producto->id}}" class="custom-control-input" @if ($producto->proveedores->contains($proveedor)) checked @endif>
        <label for="prod-{{$producto->id}}" class="custom-control-label">{{$producto->producto}} {{$producto->tamano}} {{$producto->unidadMedida}}</label>
        <div class="input-group input-group-sm mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">$</span>
            </div>
            <input type="number" class="form-control" value="{{$producto->proveedores()->find($proveedor)?$producto->proveedores()->find($proveedor)->pivot->precio:0}}" name="precio-{{$producto->id}}">
        </div>
    </div>
    {{-- <input type="checkbox" name="prod-{{$producto->id}}" id="prod-{{$producto->id}}" class="custom-control-input">
    <label for="prod-{{$producto->id}}">{{$producto->producto}} {{$producto->tamano}} {{$producto->unidadMedida}}</label> --}}
</div>
@empty

@endforelse
