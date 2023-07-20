@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Inventario <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-exchange"></i> Traslados <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-plus-square"></i> Nuevo registro
@endsection
@push('header-scripts')
    <!-- bootstrap-datetimepicker -->
    <link href="{{URL::asset('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}"
          rel="stylesheet">
    <script src="{{URL::asset('lib/validatorFields.js')}}"></script>
@endpush

@section('content')
    @include('partials._alerts')
    @include('pages.master.transfer.partials.fields',['branch'=>$branch,'data'=>$transfer])
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

        function seleccionarDestino() {
            console.log(22);
            var prov = $("select[name=branch]").val();
            if (prov != ' ') {
                $("input[name=branch_id]").val(prov);
            } else {
                $("input[name=branch_id]").val('');
            }
        }

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
            console.log(code);
            if (parseInt($("input[name=quantity]").val()) > 0) {
                if (parseInt(code) > 0) {
                    $('input[name=codeHidden]').val('')
                    $.get("{{route('transfer.addItem','')}}/" + code + "@" + $("input[name=quantity]").val() , $(this).serialize(),
                        function (response) {
                            window.location.href = "{{route('transfer.create')}}";
                        });
                } else {
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