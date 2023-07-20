@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Inventarios <i class="fa fa-angle-double-right"></i>
    <i class="fa fa-exchange"></i> Traslados
@endsection
@section('search')
    @include ('partials._search',['path'=>route('transfer.index'),'search'=>$search])
@endsection
@section('content')
    @include('partials._alerts')
    <div class="row">
        <a href="{{route('transfer.create')}}" class="btn btn-success" title="Añadir registro"><i
                    class="fa fa-plus-square"></i> </a>
        <table id="datatable" class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">Fecha de registro</th>
                <th class="column-title">Registrada por</th>
                <th class="column-title">Folio</th>
                <th class="column-title">Destino</th>
                {{--<th class="column-title">Estatus</th>--}}
                <th class="column-title">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
                @if($row->status!="nueva")
                    <tr>
                        <td>{{date('d-m-Y h:i:s', strtotime($row->updated_at))}}</td>
                        <td>{{$row->createUser->name}}</td>
                        <td>{{str_pad($row->id,7,"0",STR_PAD_LEFT)}}</td>
                        <td>{{$row->branch->name}}</td>
                        <td><a href="{{route('transfer.show',$row->id)}}" class="btn btn-primary btn-small">
                                <i class="fa fa-eye"></i></a></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

    </div>
@endsection