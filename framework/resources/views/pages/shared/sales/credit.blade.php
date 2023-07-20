@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Ventas <i class="fa fa-angle-double-right"></i> <i class="fa fa-barcode"></i> Cobrar
@endsection
@section('content')
    @include('partials._alerts')
    <div class="row">
        <h4>Venta a crédito</h4>
        <h2>Total: ${{number_format($sale->mount,2)}}</h2>
    </div>
    {{ Form::open(['action' => ['master\SalesController@storecredit'], 'method' => 'POST','class'=>'form-horizontal form-label-left']) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-2 col-xs-12">&nbsp;</div>
        <div class="col-md-4 col-xs-10">
            {{Form::Label('Clientes')}}
            <select class="form-control" name="customer" style="font-size: 18px!important;">
                <option value=" ">Seleccionar...</option>
                @foreach($customer as $row)
                    <option value="{{$row->id}}">{{$row->name}} {{$row->first_surname}} {{$row->second_surname}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-xs-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2 col-xs-12">&nbsp;</div>
        <div class="col-md-4 text-center">
            <button type="submit" class="btn btn-success" style="margin-left: -10px!important;margin-top: 2px!important;">Añadir a la cuenta</button>
        </div>
    </div>

    {{ Form::close() }}
    <hr>
    <h4>Si el cliente no se encuentra en la lista. Favor de añadirlo</h4>

    {{ Form::open(['action' => ['master\SalesController@newcredit'], 'method' => 'POST','class'=>'form-horizontal form-label-left']) }}
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('name','',['class'=>'form-control has-feedback-left','placeholder'=>'Nombre'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('firts_name','',['class'=>'form-control has-feedback-left','placeholder'=>'Primer apellido'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('second_name','',['class'=>'form-control has-feedback-left','placeholder'=>'Segundo apellido'])}}
            <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
        </div>

    </div>
    <div class="row">
        <div class="col-md-2 center">
            <button type="submit" class="btn btn-success" style="margin-left: -10px!important;margin-top: 2px!important;">Crear cuenta</button>
        </div>
    </div>

    {{ Form::close() }}
@endsection