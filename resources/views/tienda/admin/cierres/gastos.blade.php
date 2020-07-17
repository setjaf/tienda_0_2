@forelse ($gastos as $gasto)
<div class="col-12 col-md-6 p-2">
    <div class="d-flex justify-content-between align-center border rounded p-2" style="border-left:{{$gasto->tipoGasto->color}} solid 5px !important;">
        <div>
            <span class="align-self-center">{{$gasto->descripcion}}</span>
            <br>
            <span>{{$gasto->fecha->format('d-m-Y')}}</span>
            <br>
            <small>{{$gasto->tipoGasto->nombre}}</small>
        </div>
        <div class="d-flex justify-content-between">
            <div class="form-group mx-4 my-auto">
                <label for="">Importe:</label><br>
                <span class="h5">${{$gasto->importe}}</span>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 col-md-12">
    <div class="d-flex justify-content-between align-center p-4 text-center border rounded">
        <span class="align-self-center">No hay gastos registrados para este cierre.</span>
    </div>
</div>
@endforelse
