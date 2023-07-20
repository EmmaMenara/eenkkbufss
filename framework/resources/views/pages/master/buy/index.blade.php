@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Inventarios <i class="fa fa-angle-double-right"></i> <i class="fa fa-edit"></i> Compras
@endsection
@section('search')
    @include ('partials._search',['path'=>route('buy.index'),'search'=>$search])
@endsection
@section('content')
    @include('partials._alerts')
    <div class="row">
        <a href="{{route('buy.create')}}" class="btn btn-success" title="Añadir registro"><i
                    class="fa fa-plus-square"></i> </a>
        <table id="datatable" class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">Fecha de registro</th>
                <th class="column-title">Registrada por</th>
                <th class="column-title">Folio</th>
                <th class="column-title">Fecha de compra</th>
                <th class="column-title">No. de documento</th>
                <th class="column-title">Proveedor</th>
                <th class="column-title text-center">Total</th>
                <th class="column-title">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{date('d-m-Y h:i:s',strtotime($row->created_at))}}</td>
                    <td>{{$row->createUser->name}}</td>
                    <td> {{ str_pad($row->id, 6, "0", STR_PAD_LEFT)}}</td>
                    <td>{{date('d-m-Y',strtotime($row->date_buy. " 00:00:00"))}}</td>
                    <td>{{$row->num_docto}}</td>
                    <td>{{$row->suppliers->provider_name}}</td>
                    <td class="text-right">${{number_format($row->mount,2)}}</td>
                    <td>
                        <a href="{{route('buy.show',$row->id)}}" class="btn btn-sm btn-primary"
                        title="Consultar compra">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection