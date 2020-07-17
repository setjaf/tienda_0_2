@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Administración') }}</span>
                    <a href="{{route('tienda')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir al inicio
                    </a>
                </div>

                <div class="card-body">

                    <div class="row justify-content-center">

                        <div class="col-md-4">
                            <a href="{{route('tienda.admin.empleados')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">supervisor_account</i>
                                    <p>Empleados</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{route('tienda.admin.gastos')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">account_balance_wallet</i>
                                    <p>Gastos</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{route('tienda.admin.cierres')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">list_alt</i>
                                    <p>Cierres</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{url('tienda/proveedores/')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">assessment</i>
                                    <p>Resultados</p>
                                </div>
                            </a>
                        </div>

                        {{-- @if (Auth::user()->id == $tiendaLog->administrador->id)
                        <div class="col-md-4">
                            <a href="{{url('tienda/admin/')}}" class="text-secondary">
                                <div class="p-5 text-center">
                                    <i class="material-icons" style="font-size: 70px">storefront</i>
                                    <p>Administración</p>
                                </div>
                            </a>
                        </div>
                        @endif --}}


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
