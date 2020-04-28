@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Tiendas') }}</div>

                <div class="card-body">

                    <div class="row justify-content-center">

                        @forelse ($tiendas as $tienda)
                        <div class="col-md-4">
                            <div class="card w-100" style="width: 18rem;">

                                <div class="card-header">{{$tienda->nombre}}</div>

                                <img class="card-img-top" src="{{asset('img/tiendas/'.$tienda->imagen)}}" alt="Imagen de la tienda">

                                <div class="card-body">

                                    {{-- <h5 class="card-title">{{$tienda->nombre}}</h5> --}}

                                    <form id="tienda-entrar-{{$tienda->id}}" action="{{route('tienda.entrar')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="idTienda" value="{{$tienda->id}}">
                                    </form>

                                    <a href="{{route('tienda.entrar')}}" class="btn btn-primary" onclick="event.preventDefault();
                                            document.getElementById('tienda-entrar-{{$tienda->id}}').submit();">
                                        {{__('Entrar')}}
                                    </a>
                                </div>

                            </div>
                        </div>
                        @empty

                        @endforelse

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
