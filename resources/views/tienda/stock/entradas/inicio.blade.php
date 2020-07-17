@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <span class="h4">{{ __('Entradas') }}</span>
                    <a href="{{route('tienda.stock')}}" class="position-absolute text-truncate w-25" style="left: 10px;">
                        <i class="material-icons align-bottom">arrow_back_ios</i>Ir al stock
                    </a>
                </div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if(session()->has('messageError'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('messageError') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ implode('', $errors->all(':message')) }}
                        </div>
                    @endif
                    <div class="row justify-content-center my-auto">

                        <div class="col-12 text-center row justify-content-center">
                            <div class="col-md-4">
                                <a href="{{route('stock.showNuevaEntrada')}}" class="text-secondary nuevaEntrada">
                                    <div class="p-3 text-center">
                                        <i class="material-icons" style="font-size: 70px">add_box</i>
                                        <p>Nueva entrada</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 row overflow-auto lista-entradas" id="entradas" style="max-height:500px;">

                        @include('tienda.stock.entradas.entradas')

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')

    <script>
        function FDtoJSON(FormData) {
            let object = {};
            object['productos'] = [];
            FormData.forEach(
                (value,key)=>{
                    if (key.includes("prod-")) {
                        object['productos'].push(key.split('prod-')[1]);
                    }else if(value!=''){
                        object[key]=value;
                    }
                }
            );
            return object;
        }

        function fetch_data(data,url) {

            $.ajax({
                url:url,
                data: data,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:"POST",
                success:function(data)
                {
                    //console.log(data);
                    $("#productos").html(data);
                },
                error:function (error) {
                    console.log(error);
                }
            });

        }

        let loader = `<div class="d-flex justify-content-center">
                <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>`;

        function filtrar($event, items) {
            items.addClass('d-none').filter(function (item)
            {
                return ($(this)[0].dataset.nombre.toLowerCase().includes($($event.target).val().toLowerCase())) | ($(this)[0].dataset.codigo.includes($($event.target).val().toLowerCase()));
            }).removeClass('d-none');
        }

        $(document).ready(function () {


            $('#filtro').on('keyup change',function ($event) {
                var items = $('#productos div.form-group');
                console.log(items);
                filtrar($event, items);
            });
        });




    </script>

@endsection
