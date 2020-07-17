
@forelse ($ventas as $venta)
<div class="col-12 col-md-6 p-2">
    <div class="d-flex justify-content-between align-center border rounded p-2">
        <div>
            <h5 class="mb-1">{{$venta->created_at->format('d-m-Y H:i')}}</h5>
            <br>
            Productos: {{$venta->productos->count()}}
            <br>
            <a href="{{route('tienda.admin.cierres.ver.venta', ['id' => $cierre->id, 'idVenta'=>$venta->id])}}" class="editarGasto stretched-link">Ver venta</a>
        </div>
        <div class="d-flex justify-content-between">
            <div class="form-group mx-4 my-auto">
                <label for="">Importe:</label><br>
                <span class="h5">${{$venta->importe}}</span>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 col-md-12">
    <div class="d-flex justify-content-between align-center p-4 text-center border rounded">
        <span class="align-self-center">No hay ventas registradas para este cierre.</span>
    </div>
</div>
@endforelse
