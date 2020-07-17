@forelse ($cierres as $cierre)
<div class="col-12 col-md-6 p-2">
    <div class="d-flex justify-content-between align-center border rounded p-2">
        <div>
            <span class="align-self-center">{{$cierre->comeatarios}}</span>
            <br>
            <span>{{$cierre->fecha->format('d-m-Y H:i')}}</span>
            <br>
            <a href="{{route('tienda.admin.cierres.ver',$cierre->id)}}" class="stretched-link">
                Ver cierre
            </a>
        </div>
        <div class="d-flex justify-content-between">
            <div class="form-group mx-2 my-auto text-center">
                <label for="">Total en dinero:</label><br>
                <span class="h5">${{$cierre->total}}</span>
            </div>

            <div class="form-group mx-2 my-auto text-center">
                <label for="">Total en ventas:</label><br>
                <span class="h5">${{$cierre->totalVentas}}</span>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 col-md-12">
    <div class="d-flex justify-content-between align-center p-4 text-center border rounded">
        <span class="align-self-center">No hay cierres registrados para este día.</span>
    </div>
</div>
@endforelse
