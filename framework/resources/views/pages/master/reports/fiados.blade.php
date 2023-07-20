@extends('layouts.app')
@section('title')
    <i class="fa fa-th-list"></i> Reportes <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-users"></i> Fiados
@endsection

@section('content')

    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th style="width: 20px!important;">#</th>
                <th style="width: 400px!important;">{{count($creditos)}} FIADOS</th>
                <th style="width: 25px!important;">&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php $counter = 1; ?>
            @foreach($creditos as $row)
                <tr>
                    <td>{{$counter++}}</td>
                    <td>
                        <a href="{{route('reports.detalle-fiado',$row->id)}}">
                            {{$row->name}} {{$row->first_surname}} {{$row->second_surname}}
                        </a>
                    </td>
                    <td>
                        <a href="{{route('reports.detalle-fiado',$row->id)}}"
                           title="Consultas fiados"
                           class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                    <th>&nbsp;</th>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="4">Total de fiados: {{count($creditos)}}</th>
            </tr>
            </tfoot>
        </table>
    </div>

@endsection