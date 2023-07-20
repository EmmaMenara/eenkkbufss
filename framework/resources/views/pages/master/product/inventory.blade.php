@extends('layouts.app')
@section('title')
    <i class="fa fa-exchange"></i> Inventario <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-list-alt"></i> Consultar
@endsection
{{--
@section('search')
    @include ('partials._search',['path'=>route('product.inventory'),'search'=>$search,'msg'=>true])
@endsection
--}}

@push('header-scripts')
    <style type="text/css">
        .claseimg {
            width: 80px !important;
            height: 80px !important;
        }
    </style>
@endpush
@section('content')
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
            <h3>Inventario en {{$sucursal->name}} {{--\Auth::user()->surcusal['name']--}}</h3>
        </div>

        <div class="col-md-8 col-sm-12 col-xs-12 form-group pull-right top_search">
            @if((\Auth::user()->hasRole('admin'))||(\Auth::user()->hasRole('master')))
                {!! Form::open(['url' => route('product.inventory'), 'method' => 'post']) !!}
                <div class="input-group">
                                <span class="input-group-btn">

                                        <select class="form-control" style="width:40%!important;" name="tienda">
                                <option value=" ">Seleccionar...</option>
                                            @foreach($branch as $item)
                                                @if(intval($sucursal->id) == intval($item->id))
                                                    <option selected value="{{$item->id}}">{{$item->name}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endif
                                            @endforeach
                            </select>
                                    <input type="text" class="form-control" name="search" value="{{$search}}"
                                           placeholder="Teclear un texto..." style="width:50%!important;">
                            <button class="btn btn-default" type="submit">Buscar!</button>
                            </span>
                </div>
                {!! Form::close() !!}
            @else
                {!! Form::open(['url' => route('inventory.index'), 'method' => 'post']) !!}
                <div class="input-group">
                                <span class="input-group-btn">

                                    <input type="text" class="form-control" name="search" value="{{$search}}"
                                           placeholder="Teclear un texto...">
                            <button class="btn btn-default" type="submit">Buscar!</button>
                            </span>
                </div>
                {!! Form::close() !!}
            @endif
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
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
        @include('partials._alerts')
    </div>
    <div class="row">
        <table id="datatable" class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">No</th>
                <th class="column-title">C&oacute;digo de barras</th>
                <th class="column-title">Nombre</th>
                @if(intval($sucursal->id)===1)
                    <th class="column-title text-center">Existencias<br/>en Matriz</th>
                    <th class="column-title text-center">Precio de venta<br/>en Matriz</th>
                    <th class="column-title text-center">Existencias<br/>en Sucursales</th>
                    <th class="column-title">Precio de venta<br/>en Sucursales</th>
                @else
                    <th class="column-title text-center">Existencias</th>
                    <th class="column-title text-center">Precio de venta</th>
                @endif
            </tr>
            </thead>
            <tbody>
            <?php $counter = $data->firstItem(); ?>
            @foreach($data as $row)

                {{--@if(($row->existence)<($row->stock_min))
                    <tr style="color: #E9EDEF!important;
    background-color: rgba(231, 76, 60, 0.88)!important;
    border-color: rgba(231, 76, 60, 0.88)!important;font-weight: bold!important;">
                @else
                    @if(($row->existence)==($row->stock_min))
                        <tr style="color: #E9EDEF!important;
    background-color: rgba(243, 156, 18, 0.88)!important;
    border-color: rgba(243, 156, 18, 0.88)!important;font-weight: bold!important;">
                    @else
                        <tr style="   color: #E9EDEF!important;
    background-color: rgba(52, 152, 219, 0.88)!important;
    border-color: rgba(52, 152, 219, 0.88)!important;font-weight: bold!important;">
                    @endif
                @endif--}}

                    {{--<td>{{$row->unit_price1}}</td>--}}
                    @php
                        $existenciaSucursal='';
                        $precioSucursal='';
                        $existenciaMatriz='';
                        $precioMatriz='';
                        $pintar=false;
                    @endphp
                    @foreach($row->detailsData($sucursal->id)->get() as $item)
                        @if(intval($item->pivot->branch_id)===intval($sucursal->id))
                            @php $pintar=true; @endphp

                            @if(intval($sucursal->id)===1)
                                <?php
                                $existenciaMatriz = $item->pivot->existence;
                                $precioMatriz = "$" . number_format($item->pivot->unitprice1, 2);
                                ?>
                            @else
                                <?php
                                $idBranch = $item->pivot->branch_id;
                                $ob = \App\Cms\Branch::find($idBranch);
                                $existenciaSucursal .= $item->pivot->existence . "<br>";
                                $precioSucursal .= "$" . number_format($item->pivot->unitprice1, 2) . "<br>";
                                ?>
                            @endif
                        @else
                            @if(intval($sucursal->id)===1)
                                @if((\Auth::user()->hasRole('admin'))||(\Auth::user()->hasRole('master')))
                                    <?php
                                    $idBranch = $item->pivot->branch_id;
                                    $ob = \App\Cms\Branch::find($idBranch);
                                    $existenciaSucursal .= $item->pivot->existence . " en " . $ob->name . "<br>";
                                    $precioSucursal .= "$" . number_format($item->pivot->unitprice1, 2) . " en " . $ob->name . "<br>";
                                    ?>
                                @endif
                            @endif
                        @endif

                    @endforeach
                @if($pintar)
                <tr>
                    <td>{{$counter++}}</td>
                    <td>{{$row->codebar}}</td>
                    <td>{{$row->name}}</td>
                    @if(intval($sucursal->id)===1)
                        <td class="text-center">{!! $existenciaMatriz !!}</td>
                        <td class="text-right">{!! $precioMatriz !!}</td>
                    @endif
                    <td class="text-center">{!! $existenciaSucursal !!}</td>
                    <td class="text-right">{!! $precioSucursal !!}</td>
                </tr>
                @endif
            @endforeach

            </tbody>
        </table>
        {!! $data->setPath(route('product.index'))->appends(Request::except('page'))->render() !!}
    </div>
@endsection