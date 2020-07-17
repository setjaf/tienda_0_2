@forelse ($tiposGasto as $tipo)
    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
@empty
    <option value="">Debes agregar al menos un tipo de gasto</option>
@endforelse
