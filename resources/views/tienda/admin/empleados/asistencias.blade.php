@forelse ($asistencias as $asistencia)
<div class="col-12 col-md-6 p-2">
    <div class="d-flex justify-content-between align-center border rounded p-2">
        <span class="align-self-center">{{$asistencia->fechaCompleta}}</span>

        <div class="d-flex justify-content-between">
            <div class="form-group mx-4 my-auto">
                <label for="">Entrada:</label><br>
                <span class="h5">{{$asistencia->entrada!=null?$asistencia->entrada->format('h:i'):"SR"}}</span>
            </div>
            <div class="form-group mx-4 my-auto">
                <label for="">Salida:</label><br>
                <span class="h5">{{$asistencia->salida!=null?$asistencia->salida->format('h:i'):"SR"}}</span>
            </div>
        </div>

    </div>
</div>
@empty
<div class="col-12 col-md-12 p-2">
    <div class="d-flex justify-content-between align-center p-4 text-center border rounded p-2">
        <span class="align-self-center">No hay asistencias registradas para este mes.</span>
    </div>
</div>
@endforelse

