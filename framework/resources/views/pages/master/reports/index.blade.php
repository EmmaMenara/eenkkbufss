@extends('layouts.app')
@section('title')
    <i class="fa fa-th-list"></i> Reportes
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="block">
                <ul class="list-unstyled timeline">
                    <li><a href="{{route('reports.fiados')}}" class="tag"><span>Fiados</span></a></li>
                    <li>&nbsp;</li>
                    <li><a href="{{route('reports.sales')}}" class="tag"><span>Ventas</span></a></li>
                </ul>
            </div>

        </div>
    </div>

@endsection