
@forelse ($entradas as $entrada)
<div class="col-12 col-md-6 p-2">
    <div class="d-flex justify-content-between align-center border rounded p-2">
        <div>
            <h5 class="mb-1">{{$entrada->created_at->format('d-m-Y H:i')}}</h5>
            <br>
            Productos: {{$entrada->productos->count()}}
            <br>
            <a href="{{route('tienda.admin.cierres.ver.entrada', ['id' => $cierre->id, 'idEntrada'=>$entrada->id])}}" class="editarGasto stretched-link">Ver entrada</a>
        </div>
        <div class="d-flex justify-content-between">
            <div class="form-group mx-4 my-auto">
                <label for="">Importe:</label><br>
                <span class="h5">${{$entrada->total}}</span>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 col-md-12">
    <div class="d-flex justify-content-between align-center p-4 text-center border rounded">
        <span class="align-self-center">No hay entradas registradas para este cierre.</span>
    </div>
</div>
@endforelse
