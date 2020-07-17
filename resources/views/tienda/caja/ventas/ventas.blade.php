
@foreach ($ventas as $venta)
<div class="col-md-4 my-2 venta" data-fecha='{{$venta->created_at->format('d-m-Y H:i')}}'>
    <div class="card mx-auto d-flex" >

        <div class="row no-gutters">

            {{-- <div class="col-4 overflow-hidden d-flex p-3">
                <img src="{{url('img/ventas/'.$venta->imagen)}}" alt="No se encontró la imagen" class="mw-100 mh-100 m-auto">
            </div> --}}

            <div class="col-12">
                <div class="card-body">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{$venta->created_at->format('d-m-Y H:i')}}</h5>
                        {{-- <small>{{$venta->id}}</small> --}}
                    </div>
                    <p class="card-text">
                        ${{$venta->importe}}
                        <br>
                        Productos: {{$venta->productos->count()}}
                    </p>
                    <a href="{{route('caja.showVenta',$venta->id)}}" class="btn btn-link editarventa"
                        {{-- data-fecha='{{$venta->created_at->format('d-m-Y H:i')}}'
                        data-idventa='{{$venta->id}}' --}}
                    >Ver ticket</a>
                </div>
            </div>

        </div>

    </div>
</div>
@endforeach
</div>

<div class="w-100"></div>

{{-- {{$ventas->links()}} --}}
