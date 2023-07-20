@extends('layouts.app')
@section('title')
    <i class="fa fa-th-list"></i> Reportes <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-users"></i> Fiados <i class="fa fa-angle-double-right"></i> Detale
@endsection

@section('content')
    <div class="row">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="bg-primary" style="width: 150px!important;">Cliente</th>
                <td colspan="3">{{$customer->name}} {{$customer->first_surname}} {{$customer->second_surname}}</td>
                <th class="bg-primary" style="width: 150px!important;">&Uacute;ltimo abono</th>
                <td class="text-center" style="width: 150px!important;">{{date('d-m-Y h:i:s')}}</td>
            </tr>
            <tr>
                <th class="bg-primary" style="width: 150px!important;">Cr&eacute;dito actual</th>
                <td class="text-right">${{number_format($customer->current_credit)}}</td>
                <th class="bg-primary" style="width: 150px!important;">Abonos</th>
                <td class="text-right">${{number_format($customer->current_credit)}}</td>
                <th class="bg-primary" style="width: 150px!important;">Saldo actual</th>
                <td class="text-right">${{number_format($customer->current_credit)}}</td>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th style="width: 80px!important;">Folio</th>
                <th> Fecha de venta</th>
                <th> Último abono</th>
                <th class="text-center">Importe</th>
                <th class="text-center">Abono</th>
                <th class="text-center">Saldo</th>
                <th class="text-center">&nbsp;</th>
            </tr>
            </thead>
            <tbody>

            @foreach($data as $row)
                <tr>
                    <th class="bg-orange">{{$row->id}}</th>
                    <th class="bg-orange">{{date('d-m-Y h:i:s',strtotime($row->created_at))}}</th>
                    <th class="bg-orange">{{date('d-m-Y h:i:s',strtotime($row->created_at))}}</th>
                    <th class="bg-orange text-center">${{number_format($row->mount,2)}}</th>
                    <th class="bg-orange text-center">${{number_format($row->mount,2)}}</th>
                    <th class="bg-orange text-center">${{number_format($row->mount,2)}}</th>
                    <th colspan="3" class="text-center bg-orange">
                        <a href="#" class="btn btn-sm btn-dark  "><i class="fa fa-print"></i> Detalle de abonos</a></th>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <th class="text-center">Cant.</th>
                    <th>Nombre</th>
                    <th class="text-right">Precio de venta</th>
                    <th class="text-right">Importe</th>
                    <th class="text-right">Costo</th>
                    <th class="text-right">Abono</th>
                    <th class="text-right">Saldo</th>
                    <th>&nbsp;</th>
                </tr>
                @foreach($row->products as $item)
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td class="text-center">{{$item->pivot->quantity}}</td>
                        <td>{{$item->name}}</td>
                        <td class="text-right">${{number_format($item->pivot->unitprice,2)}}</td>
                        <td class="text-right">
                            ${{number_format(($item->pivot->quantity*$item->pivot->unitprice),2)}}</td>
                        <td class="text-right">
                            ${{number_format(($item->pivot->quantity*$item->pivot->unitprice),2)}}</td>
                        <td class="text-right">
                            ${{number_format(($item->pivot->quantity*$item->pivot->unitprice),2)}}</td>
                        <td class="text-right">
                            ${{number_format(($item->pivot->quantity*$item->pivot->unitprice),2)}}</td>
                        <td class="text-center">
                            <a href="#" title="Abonar">
                                <i class="fa fa-plus-circle bg-primary btn"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <a href="{{route('reports.index')}}" class="btn btn-primary">Volver</a>
    </div>

@endsection