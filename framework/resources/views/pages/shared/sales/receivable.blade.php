@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Ventas <i class="fa fa-angle-double-right"></i> <i class="fa fa-barcode"></i> Cobrar
@endsection
@push('header-scripts')
    <script src="{{asset('lib/validatorFields.js')}}"></script>
@endpush
@section('content')
    @include('partials._alerts')
    {{ Form::open(['action' => ['master\SalesController@store'], 'method' => 'POST','class'=>'form-horizontal form-label-left']) }}
    {{ csrf_field() }}
    <div class="row">
        <h3 class="text-center bg-blue-sky">VENTA DE CONTADO{{$errors}}</h3>

        <h2 class="text-center">Total: ${{number_format($sale->mount,2)}}</h2>
        {{ Form::hidden('total', $sale->mount)}}
    </div>

    <div class="row" name="existente">
        <div class="col-md-6 col-xs-12 col-md-offset-2">
            <div class="row">
                <div class="col-md-8 col-xs-10">
                    {{Form::Label('Clientes registrados')}}
                    <select class="form-control" name="customer" onchange="mostrar();"
                            style="font-size: 18px!important;">
                        <option value=" ">Seleccionar...</option>
                        <option value="99999">Registrar nuevo cliente</option>
                        @foreach($customer as $row)
                            <option value="{{$row->id}}">{{$row->name}} {{$row->first_surname}} {{$row->second_surname}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('customer'))
                        <div class="alert-error">
                            <strong>{{ "Campo obligatorio"}}</strong>
                        </div>
                    @endif
                    @if ($errors->has('name'))
                        <div class="alert-error">
                            <strong>{{ "No indico el nombre y apellidos del nuevo cliente"}}</strong>
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-3">&nbsp;</div>
    </div>
    <div class="row" name="nuevo">
        <div class="col-md-6 col-xs-12 col-md-offset-2">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                    {{Form::text('name','',['class'=>'form-control has-feedback-left','placeholder'=>'Nombre del cliente'])}}
                    <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                    {{Form::text('firts_name','',['class'=>'form-control has-feedback-left','placeholder'=>'Primer apellido del cliente'])}}
                    <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                    {{Form::text('second_name','',['class'=>'form-control has-feedback-left','placeholder'=>'Segundo apellido del cliente'])}}
                    <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            <div class="row">
                <input type="button" value="Cancelar registro de nuevo cliente" class="btn btn-dark"
                       onclick="activar()"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-xs-12 col-md-offset-2">
            {{Form::Label('Efectivo')}}
            {{ Form::text('efectivo', '0', ['class'=>'form-control text-right','style'=>'font-size: 18px;','autocomplete'=>'off', 'placeholder' =>  '0.00','maxlength'=>"10",'onkeypress'=>'return FenixFloat(event,this);','onkeyup'=>'FenixZero(event,this)'])}}
            @if ($errors->has('efectivo'))
                <div class="alert-error">
                    <strong>{{ "El valor mínimo debe ser el total de la venta"}}</strong>
                </div>
            @endif
        </div>
        <div class="col-md-3 col-xs-12 col-md-offset-0 text-left"><br/>
            <button type="submit" class="btn btn-success"
                    style="margin-left: -10px!important;margin-top: 2px!important;">Cobrar
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12 col-md-offset-2">
            {{Form::Label('Cambio')}}
            {{ Form::text('cambio', '0', ['class'=>'form-control text-right','style'=>'font-size: 18px;','readonly'=>'true','placeholder' =>  '0.00'])}}
        </div>
    </div>
    {{ Form::close() }}
@endsection

@push('scripts')
    <script>

        $(function () {
            $("div[name=nuevo]").hide();
            $("div[name=existente]").show();
        })

        $("input[name=efectivo]").keyup(function () {
            var total = parseFloat($("input[name=total]").val());
            var pagoRecibido = parseFloat($(this).val());
            var cambio = (pagoRecibido - total);
            if (cambio > 0) {
                $("input[name=cambio]").val(cambio.toFixed(2));
            } else {
                $("input[name=cambio]").val('0.00');
            }
        });

        function mostrar() {
            var id = $("select[name=customer]").val();
            if (parseInt(id) === 99999) {
                $("div[name=nuevo]").show();
                $("div[name=existente]").hide();
            } else {
                $("div[name=nuevo]").hide();
                $("div[name=existente]").show();
            }
        }

        function activar() {
            $("select[name=customer]").val(' ');
            $("div[name=nuevo]").hide();
            $("div[name=existente]").show();
            $("input[name=name]").val('');
            $("input[name=firts_name]").val('');
            $("input[name=second_name]").val('');
        }
    </script>
@endpush