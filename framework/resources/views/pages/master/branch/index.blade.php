@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Cat&aacute;logos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-building-o"></i> Sucursales
@endsection
@section('search')
    @include ('partials._search',['path'=>route('branch.index'),'search'=>$search])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2 col-sm-12 col-xs-12" style="margin-top: -30px!important;">
            <a href="{{route('branch.create')}}" class="btn btn-success" title="Añadir registro"><i
                        class="fa fa-plus-square"></i> </a>
        </div>
        <div class="col-md-5 col-sm-12 col-xs-12" style="margin-top: -30px!important;">
            <strong>{{$data->total()}}</strong> Registro(s) encontrado(s).
            P&aacute;gina
            <strong>{{($data->total()==0) ? '0' : $data->currentPage()}}</strong> de
            <strong> {{$data->lastPage()}}</strong>
            <br>
            Registros por p&aacute;gina
            <strong>{{($data->total()==0) ? '0' : $data->perPage()}}</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('partials._alerts')
        </div>
    </div>
    <div class="row">
        <table id="datatable" class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">Clave</th>
                <th class="column-title">Nombre</th>
                <th class="column-title">Direcci&oacute;n</th>
                <th class="column-title">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->direction}}</td>
                    <td>
                        @if(($row->id)>1)
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="{{route('branch.edit',$row->id,'edit')}}"
                                       class='btn btn-xs btn-success' title='Editar'><i
                                                class='ace-icon fa fa-pencil-square-o'></i></a>
                                </div>
                                <div class="col-md-2">
                                    <form method='POST' action="{{route('branch.destroy',$row->id)}}"
                                          accept-charset='UTF-8'><input name='_method' type='hidden'
                                                                        value='DELETE'>
                                        {{csrf_field()}}
                                        <button type='submit' class='btn btn-xs btn-danger'
                                                onclick="return confirm('¿Desea eliminar la sucursal {{$row->name}}?');"
                                                title='Eliminar'><i class='ace-icon fa fa-trash-o'></i></button>
                                    </form>
                                </div>
                                <div class="col-md-8">&nbsp;</div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="{{route('branch.index')}}"
                                       class='btn btn-xs btn-success' title='Sin permisos'><i
                                                class='ace-icon fa fa-pencil-square-o'></i></a>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{route('branch.index')}}"
                                       class='btn btn-xs btn-danger' title='Sin permisos'><i
                                                class='ace-icon fa fa-trash-o'></i></a>
                                </div>
                                <div class="col-md-8">&nbsp;</div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $data->setPath(route('branch.index'))->appends(Request::except('page'))->render() !!}
    </div>
@endsection

