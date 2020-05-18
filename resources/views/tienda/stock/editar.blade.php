@extends('layouts/app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Editar producto') }}</div>

                <div class="card-body">

                    <div class="row justify-content-center my-auto">
                        @php
                            //dd($errors)
                        @endphp
                        @if(session()->has('messageError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('messageError') }}
                            </div>
                        @endif
                        @if(session()->has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form action="{{route('stock.editar',$producto->id)}}" method="POST" class="row col-12 justify-content-center" enctype="multipart/form-data">

                            @csrf

                            <div class="form-group col-md-6 row">
                                <label class="col-md-4 col-form-label text-md-right" for="codigo">{{__('Código de barras del producto:')}}</label>

                                <div class="col-md-6">
                                <input type="text" name="codigo" placeholder="750000000000" class="form-control @error('codigo') is-invalid @enderror" id="codigo" value="{{$producto->codigo}}" required autofocus>
                                    @error('codigo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row">
                                <label class="col-md-4 col-form-label text-md-right" for="producto">{{__('Nombre del producto:')}}</label>

                                <div class="col-md-6">
                                    <input type="text" name="producto" placeholder="Nombre Producto" class="form-control @error('producto') is-invalid @enderror" value="{{$producto->producto}}" required>
                                    @error('producto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row">
                                <label class="col-md-4 col-form-label text-md-right" for="formaVenta">{{__('Forma de venta:')}}</label>

                                <div class="col-md-6">
                                    <select name="formaVenta" id="formaVenta" class="form-control @error('formaVenta') is-invalid @enderror" onchange="if($('#formaVenta').val()==2){$('#group-tamano').hide()}else{$('#group-tamano').show()}" required>
                                        <option value="1" @if ($producto->formaVenta=='pieza') selected="selected" @endif>pieza</option>
                                        <option value="2" @if ($producto->formaVenta=='granel') selected="selected" @endif>granel</option>
                                    </select>
                                    @error('formaVenta')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row">
                                <label class="col-md-4 col-form-label text-md-right" for="idMarca">{{__('Marca:')}}</label>


                                <div class="col-md-6">
                                    <select name="idMarca" id="" class="form-control @error('idMarca') is-invalid @enderror" required>
                                        <option value="">Elige una marca</option>
                                        @foreach ($tiendaLog->marcas as $marca)
                                            <option value="{{$marca->id}}" @if ($marca->id==$producto->marca->id) selected @endif>{{$marca->marca}}</option>
                                        @endforeach
                                    </select>
                                    @error('idMarca')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row">
                                <label class="col-md-4 col-form-label text-md-right" for="unidadMedida">{{__('Tipo unidad de medida:')}}</label>

                                <div class="col-md-6">
                                    <select name="unidadMedida" id="" class="form-control @error('unidadMedida') is-invalid @enderror" required>
                                        <option value="1" @if ($producto->unidadMedida == 'ml') selected @endif>ml (mililitros)</option>
                                        <option value="2" @if ($producto->unidadMedida == 'g') selected @endif>g (gramos)</option>
                                        <option value="3" @if ($producto->unidadMedida == 'u') selected @endif>u (unidades)</option>
                                    </select>
                                    @error('unidadMedida')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row" id="group-tamano">
                                <label class="col-md-4 col-form-label text-md-right" for="tamano">{{__('Tamaño del producto:')}}</label>

                                <div class="col-md-6">
                                    <input type="number" name="tamano" placeholder="0.00" class="form-control @error('tamano') is-invalid @enderror" value="{{$producto->tamano}}">
                                    @error('tamano')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row" id="group-deseado">
                                <label class="col-md-4 col-form-label text-md-right" for="deseado">{{__('Cantidad de stock deseado:')}}</label>

                                <div class="col-md-6">
                                    <input type="number" name="deseado" placeholder="0.00" class="form-control @error('deseado') is-invalid @enderror" value="{{$producto->deseado}}">
                                    @error('deseado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row" id="group-disponible">
                                <label class="col-md-4 col-form-label text-md-right" for="disponible">{{__('Cantidad de stock disponible:')}}</label>

                                <div class="col-md-6">
                                    <input type="number" name="disponible" placeholder="0.00" class="form-control @error('disponible') is-invalid @enderror" value="{{$producto->disponible}}">
                                    @error('disponible')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row" id="group-precioVenta">
                                <label class="col-md-4 col-form-label text-md-right" for="precioVenta">{{__('Precio de venta:')}}</label>

                                <div class="col-md-6">
                                    <input type="number" name="precioVenta" placeholder="0.00" class="form-control @error('precioVenta') is-invalid @enderror" value="{{$producto->precioVenta}}">
                                    @error('precioVenta')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 text-md-center row">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="activo" id="activo" @if ($producto->activo) checked @endif>
                                    <label class="custom-control-label" for="activo">Activo</label>
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="form-group col-md-6" id="group-tamano">
                                <label for="tamano">Imagen del producto:</label>
                                <div class="text-center overflow-hidden">
                                    <img id="imagenProducto" class="mw-100" src="{{url('img/productos/'.$producto->imagen)}}">
                                </div>
                                <input type="file" name="imagen" id="imagen" class="form-control">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="eliminarImagen" id="eliminarImagen">
                                    <label class="custom-control-label" for="eliminarImagen">Eliminar imagen del producto</label>
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <input type="submit" value="Guardar producto" class="btn btn-primary">



                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function readURL(input) {
        console.log(input);

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagenProducto').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }else{
            $('#imagenProducto').attr('src', '');
        }
    }
    $(document).ready(function () {

        $("#imagen").change(function() {
            readURL(this);
        });

    });
</script>
@endsection
