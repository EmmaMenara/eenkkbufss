@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Ventas <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-barcode"></i> Registrar
@endsection
@push('header-scripts')
    <style type="text/css">
        .classimg {
            width: 80px !important;
            height: 80px !important;
        }

        .padre {
            background: yellow;
            /* height: 100px;*/
            /*IMPORTANTE*/
            display: block;
            justify-content: center;
            align-items: center;
        }
    </style>
@endpush
@section('content')
    @include('partials._alerts')
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="control-label   text-right">C&oacute;digo de barras | Nombre <span
                            class="required">*</span></label>
                <div>
                    @include('pages.shared.sales.partials.searchProduct')
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="form-group">
                <div>
                    <label>Fecha actual</label>
                    {!! Form::text('date',date('d-m-Y'),['readonly'=>'true','required'=>"required",'class'=>"form-control text-center"]) !!}
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="form-group">
                <h1><label>{{(Auth::user()->NameBranch->name)}}</label></h1>
            </div>
        </div>
    </div>

    <div class="row"
         style="background-color: #DCDCDC;overflow-x: hidden;overflow-y: visible; overflow-y: scroll; height:200px;">
        @if(isset($data))
            @if(count($data)>0)
                @php
                    $cierre=false;
                     $item = 0;
                @endphp

                @foreach($data as $row)
                    @php $precio=-1; @endphp
                    @foreach ($row->detailsData(\Auth::user()->branch_id)->get() as $fila)
                        @php $existence=($fila->pivot->existence);
                        $precio = $fila->pivot->unitprice1;
                        @endphp
                    @endforeach
                    @if($precio>0)
                        @if($existence>0)
                            @if($item==0)
                                <div class="row" style="margin-left: 20px!important;">
                                    @php $cierre=false; @endphp
                                    @endif
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <th>
                                                    <a href="{{route('sales.addProduct')}}?assestId={{$sale->id}}&key={{$row->id}}&c={{$precio}}">
                                                        <i class="fa fa-plus-circle"></i></a><br/>
                                                    @php $quantity=0; @endphp

                                                    @foreach($sale->products as $record)
                                                        @if($row->id==$record->id)
                                                            @php $quantity =$record->pivot->quantity; @endphp
                                                        @endif
                                                    @endforeach
                                                    {{$quantity}}
                                                    <br/>
                                                    <a href="{{route('sales.removeProduct')}}?assestId={{$sale->id}}&key={{$row->id}}"><i
                                                                class="fa fa-minus-circle"></i></a></th>
                                                <th><img class="classimg"
                                                         src="{{URL::asset('productos/'.$row->photo)}}"/>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2" class="text-center text-bold">
                                                    <small>{{strtoupper($row->name)}}</small>
                                                    <br/>${{number_format($precio,2)}}</th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @if($item == 2)
                                        @php $cierre=true; @endphp
                                </div>
                                <div class="row"><br/></div>
                                @php $item = -1; @endphp
                            @endif
                            @php $item++; @endphp
                        @endif
                    @endif

                @endforeach
                @if(!($cierre))
    </div>
    @endif
    @endif
    @endif
    </div>
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th>Total a pagar</th>
                <th class="text-right">${{number_format($sale['mount'],2)}}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>Cant. Productos</th>
                <th class="text-right">{{$total}}</th>
            </tr>
            @if(count($sale->products)>0)
                <tr>
                    <th>Forma de pago</th>
                    <th class="text-right">
                        <a href="{{route('sales.receivable')}}" class="btn btn-primary"> <i class="fa fa-money"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{route('sales.credit')}}" class="btn btn-warning"><i class="fa fa-users"></i></a>
                    </th>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
