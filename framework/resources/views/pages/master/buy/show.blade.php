@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Inventarios <i class="fa fa-angle-double-right"></i>
    <i class="fa fa-edit"></i> Compras  <i class="fa fa-angle-double-right"></i>
    <i class="fa fa-eye"></i> Consultar compra
@endsection
@section('content')
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th>Fecha de registro:</th>
                <th>{{date('d-m-Y h:i:s',strtotime($data['created_at']))}}</th>
                <th>Registrada por:</th>
                <th>{{$data->createUser->name}} </th>
            </tr>
            <tr>
                <th>Folio:</th>
                <th>{{str_pad($data['id'],10, "0",STR_PAD_LEFT)}}</th>
                <th>Fecha de compra:</th>
                <th>{{date('d-m-Y',strtotime($data['date_buy']." 00:00:00"))}}</th>
            </tr>

            </thead>
        </table>
    </div>
    <div class="row">
        <table id="datatable" class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">Foto</th>
                <th class="column-title">Cant.</th>
                <th class="column-title">C&oacute;digo de barras</th>
                <th class="column-title">C&oacute;digo interno</th>
                <th class="column-title">Producto</th>
                <th class="column-title" style="text-align: center!important;">Costo unitario</th>
                <th class="column-title" style="text-align: center!important;">Precio de venta</th>
                <th>Importe</th>
            </tr>
            </thead>
            <tbody>
            @php $granTotal=0; @endphp
            @foreach($data->products as $row)
                <tr>
                    <td><img src="{{URL::asset('productos/'.$row->photo) }}"
                             style='height:40px!important;width:40px!important'/></td>
                    <td>{{$row->pivot->quantity}}</td>
                    <td>{{$row['codebar']}}</td>
                    <td>{{$row['codeinner']}}</td>
                    <td>{{$row['name']}}</td>
                    <td class="text-right">${{number_format($row->pivot->unitcost,2)}}</td>
                    <td class="text-right">${{number_format($row->pivot->unitpricesale,2)}} </td>
                    <td class="text-right">${{number_format(( $row->pivot->unitcost * $row->pivot->unitpricesale),2)}} </td>
                    @php
                        $granTotal+=( $row->pivot->unitcost * $row->pivot->quantity);
                    @endphp
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="8" class="text-right"><h3>Costo total: ${{number_format($granTotal,2)}}</h3></th>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="row text-left">
        <a href="{{route('buy.index')}}" class="btn btn-primary">Volver</a>
    </div>
@endsection