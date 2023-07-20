@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Inventarios <i class="fa fa-angle-double-right"></i>
    <i class="fa fa-exchange"></i> Traslados <i class="fa fa-angle-double-right"></i>
    <i class="fa fa-eye"></i> Consultar traslado
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
                <th>Destino:</th>
                <th>{{$data->branch->name}}</th>
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
                <th class="column-title" style="text-align: center!important;">Precio de venta</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->products as $row)
                <tr>
                    <td><img src="{{URL::asset('productos/'.$row->photo) }}"
                             style='height:40px!important;width:40px!important'/></td>
                    <td>{{$row->pivot->quantity}}</td>
                    <td>{{$row['codebar']}}</td>
                    <td>{{$row['codeinner']}}</td>
                    <td>{{$row['name']}}</td>
                    <td class="text-right">${{number_format($row->pivot->unitpricesale,2)}} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row text-left">
        <a href="{{route('transfer.index')}}" class="btn btn-primary">Volver</a>
    </div>
@endsection