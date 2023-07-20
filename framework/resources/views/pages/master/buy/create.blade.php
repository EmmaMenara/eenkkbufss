@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Inventario <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-edit"></i> Compras <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-plus-square"></i> Nuevo registro
@endsection
@push('header-scripts')
    <!-- bootstrap-datetimepicker -->
    <link href="{{URL::asset('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
    <script src="{{URL::asset('lib/validatorFields.js')}}"></script>
@endpush

@section('content')
    @include('partials._alerts')
    @include('pages.master.buy.partials.fields',['supplier'=>$supplier,'data'=>$buy])
@endsection

@push('scripts')
    <!-- bootstrap-daterangepicker -->
    <script src="{{URL::asset('plugins/momentjs/moment.js')}}"></script>
    <script src="{{URL::asset('plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- jQuery autocomplete -->
    <script src="{{URL::asset('plugins/devbridge-autocomplete/dist/jquery.autocomplete.min.js')}}"></script>

    <!-- bootstrap-datetimepicker -->
    <script src="{{URL::asset('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script>
        var d = new Date();

        function seleccionarProveedor() {
            var prov = $("select[name=proveedor]").val();
            if(prov!=' '){
                $("input[name=supplier_id]").val(prov);
            }else{
                $("input[name=supplier_id]").val('');
            }
        }

        function updatenumero(){
            $("input[name=num_docto]").val($("input[name=numero]").val());
        }

        $('input[name=compra]').daterangepicker({
            singleDatePicker: true,
            format: 'DD/MM/YYYY',
            maxDate:new Date(d.setDate(d.getDate())),
            minDate:new Date(d.setDate(d.getDate()-10)),
            singleClasses: "picker_4",
            locale: {
                format: 'DD-MM-YYYY'
            },
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            var str = start.toISOString();
            var res = str.substr(0, 10);
            $("input[name=date_buy]").val(res);
        });

        $('input[name=codebar]').autocomplete({
            serviceUrl: '{{route('product.autocomplete')}}',
            onSelect: function (suggestion) {
                $('input[name=codebar]').val(suggestion.value);
                $('input[name=codeHidden]').val(suggestion.data);
            }
        });

        function selectControl(name) {
            $("input[name=" + name + "]").select();
        }

        function loadData() {
            var obj = $('input[name=codeHidden]');
            obj.empty();
            var code = obj.val();
            if (parseInt($("input[name=quantity]").val()) > 0) {
                if(parseInt(code)>0){
                    var costo = $('input[name=unit_cost]').val();
                    if(parseFloat(costo)>0){
                        var price = $('input[name=unit_price]').val();
                        if(parseFloat(price)>0){
                            $('input[name=codeHidden]').val('')
                            var fecha = $("input[name=date_buy]").val();
                            $.get("{{route('buy.addItem','')}}/" + code + "@" + $("input[name=quantity]").val()+"@"+ costo+"@"+price+"@"+fecha, $(this).serialize(),
                                function (response) {
                                    window.location.href = "{{route('buy.create')}}";
                                });
                        }else{
                            alert('Ingrese el precio al público');
                        }
                    }else{
                        alert('Ingrese un costo unitario');
                    }
                }else{
                    alert('Debe ingresar un producto.');
                    $('input[name=quantity]').focus();
                    $('input[name=quantity]').select();
                }
            } else {
                alert('Debe ingresar una cantidad.');
                $('input[name=quantity]').focus();
                $('input[name=quantity]').select();
            }


        }




    </script>
    @endpush