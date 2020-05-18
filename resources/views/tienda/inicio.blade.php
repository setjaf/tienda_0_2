@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Tiendas') }}</div>

                <div class="card-body">

                    <div class="row justify-content-center">

                        <div class="col-md-4">
                            <a href="{{url('tienda/caja/')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">storefront</i>
                                    <p>Caja</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{route('stock')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">fastfood</i>
                                    <p>Stock</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{url('tienda/proveedores/')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">local_shipping</i>
                                    <p>Proveedores</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{url('tienda/admin/')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">storefront</i>
                                    <p>Administración</p>
                                </div>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
