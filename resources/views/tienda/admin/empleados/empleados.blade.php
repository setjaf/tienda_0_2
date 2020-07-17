@forelse ($empleados as $empleado)
<div class="form-group w-100" data-nombre="{{$empleado->persona->nombreCompleto}}" data-email="{{$empleado->email}}">
    <div class="custom-control custom-switch">
        <input type="checkbox" name="emp-{{$empleado->id}}" id="emp-{{$empleado->id}}" class="custom-control-input" @if ($empleado->trabajaEn->contains($tienda)) checked @endif>
        <label for="emp-{{$empleado->id}}" class="custom-control-label">{{$empleado->persona->nombreCompleto}}</label>
        <div class="row w-100">
            <div class="col">
                <select name="formapago-{{$empleado->id}}" id="formapago-{{$empleado->id}}" class="form-control form-control-sm">
                    <option value="1"
                        @if (
                            $empleado->trabajaEn->contains($tienda) &&
                            $empleado->trabajaEn()->find($tienda->id)->pivot->formaPago == 'diario'
                        ) selected @endif
                    >Diario</option>
                    <option value="2"
                        @if (
                            $empleado->trabajaEn->contains($tienda) &&
                            $empleado->trabajaEn()->find($tienda->id)->pivot->formaPago == 'semanal'
                        ) selected @endif
                    >Semanal</option>
                    <option value="3"
                        @if (
                            $empleado->trabajaEn->contains($tienda) &&
                            $empleado->trabajaEn()->find($tienda->id)->pivot->formaPago == 'quincenal'
                        ) selected @endif
                    >Quincenal</option>
                </select>
            </div>
            <div class="input-group input-group-sm mb-1 col-md-6">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                <input type="number" class="form-control form-control-sm" value="{{$empleado->trabajaEn->contains($tienda->id)?$empleado->trabajaEn()->find($tienda->id)->pivot->sueldo:0.00}}" name="sueldo-{{$empleado->id}}">
            </div>
        </div>
    </div>
    {{-- {{$empleado->proveedores()->find($proveedor)?$empleado->proveedores()->find($proveedor)->pivot->precio:0}} --}}
    {{-- <input type="checkbox" name="emp-{{$empleado->id}}" id="emp-{{$empleado->id}}" class="custom-control-input">
    <label for="emp-{{$empleado->id}}">{{$empleado->empleado}} {{$empleado->tamano}} {{$empleado->unidadMedida}}</label> --}}
</div>
@empty

@endforelse
