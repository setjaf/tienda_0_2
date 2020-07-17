
@foreach ($entradas as $entrada)
<div class="col-md-4 my-2 entrada" data-fecha='{{$entrada->created_at->format('d-m-Y H:m:s')}}'>
    <div class="card mx-auto d-flex" >

        <div class="row no-gutters">

            {{-- <div class="col-4 overflow-hidden d-flex p-3">
                <img src="{{url('img/entradas/'.$entrada->imagen)}}" alt="No se encontró la imagen" class="mw-100 mh-100 m-auto">
            </div> --}}

            <div class="col-12">
                <div class="card-body">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{$entrada->created_at->format('d-m-Y')}}</h5>
                        {{-- <small>{{$entrada->id}}</small> --}}
                    </div>
                    <p class="card-text">${{$entrada->total}}</p>
                    <a href="{{route('stock.showEntrada',$entrada->id)}}" class="btn btn-link editarEntrada"
                        {{-- data-fecha='{{$entrada->created_at->format('d-m-Y H:m:s')}}'
                        data-identrada='{{$entrada->id}}' --}}
                    >Ver entrada</a>
                </div>
            </div>

        </div>

    </div>
</div>
@endforeach
</div>

<div class="w-100"></div>

{{$entradas->links()}}
