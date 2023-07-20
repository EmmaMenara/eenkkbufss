@extends('layouts.default')
@section('theme')
    nav-md
@endsection
@section('head')
    @parent
    <!-- Datatables -->
    <link href="{{URL::asset('/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">


@endsection
@section('content')

    <div class="right_col" role="main" style="min-height: 3742px;">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Cat&aacute;logo <?php $pat = base_path('public/img/'); ?></h3>
                </div>
                <div class="title_right">
                    <div class="col-md-9 col-sm-9 col-xs-12 form-group pull-right top_search">
                        {!! Form::open(['url' => route('products.index'), 'method' => 'get']) !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" value="{{$search}}"
                                   placeholder="Teclear [código|categoría|nombre] para buscar...">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Buscar!</button>
                    </span>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <h2>Productos</h2>
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><strong>{{$data->total()}}</strong> Registro(s) encontrado(s).
                                        P&aacute;gina
                                        <strong>{{($data->total()==0) ? '0' : $data->currentPage()}}</strong> de
                                        <strong> {{$data->lastPage()}}</strong>.
                                        Registros por p&aacute;gina
                                        <strong>{{($data->total()==0) ? '0' : $data->perPage()}}</strong></h5>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 text-right">
                                    @if(\Auth::user()->hasAnyRole('admin'))
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li>
                                                <a href="{{route('products.create')}}" class="btn btn-primary"
                                                   aria-expanded="false" title="Nuevo">Nuevo <i
                                                            class="fa fa-plus-circle"></i></a>
                                            </li>

                                            </li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @include('includes.alerts')
                            <table id="datatable" class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                    <th>No.</th>
                                    <th class="column-title">Foto</th>
                                    <th class="column-title">C&oacute;digo de barras</th>
                                    <th class="column-title">C&oacute;digo de producto</th>
                                    <th class="column-title">Categor&iacute;a</th>
                                    <th class="column-title">Nombre</th>
                                    @if(\Auth::user()->hasAnyRole('admin'))
                                        <th class="column-title text-center">Acciones</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <?php $counter = $data->firstItem(); ?>
                                @foreach($data as $row)
                                    <tr>
                                        <td>{{$counter++}}</td>
                                        <td><img src="{{'./../framework/public/img/'.$row->photo}}"
                                                 style='height:50px!important;width:50px!important'/></td>
                                        <td>{{$row->codebar	}}</td>
                                        <td>{{$row->code	}}</td>
                                        <td>{{$row->category['name']}}</td>
                                        <td>{{$row->name}}</td>
                                        @if((\Auth::user()->hasAnyRole('admin'))||((\Auth::user()->name=="Ana")))
                                        <td>
                                            <div class="row">
												@if((\Auth::user()->hasAnyRole('admin')))
                                                <div class="col-md-2"><a
                                                            href="{{route('products.show',$row->id,'show')}}"
                                                            class='btn btn-xs btn-warning' title='Ficha técnica'><i
                                                                class='ace-icon fa fa-newspaper-o'></i></a>
                                                </div>
                                                <div class="col-md-1">&nbsp;
                                                </div>
                                                @endif
                                                @if((\Auth::user()->hasAnyRole('admin'))||((\Auth::user()->name=="Ana")))
                                                <div class="col-md-2">
                                                    <a href="{{route('products.edit',$row->id,'edit')}}"
                                                       class='btn btn-xs btn-success' title='Editar'><i
                                                                class='ace-icon fa fa-pencil-square-o'></i></a>
                                                </div>
                                                @endif
                                                <div class="col-md-1">&nbsp;
                                                </div>
                                                @if((\Auth::user()->hasAnyRole('admin')))
                                                <div class="col-md-2">
                                                    <form method='POST' action="{{route('products.destroy',$row->id)}}"
                                                          accept-charset='UTF-8'><input name='_method' type='hidden'
                                                                                        value='DELETE'>
                                                        {{csrf_field()}}
                                                        <button type='submit' class='btn btn-xs btn-danger'
                                                                onclick="return confirm('¿Desea eliminar el producto {{$row->name}}?');"
                                                                title='Eliminar'><i class='ace-icon fa fa-trash-o'></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-md-1">&nbsp;
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="{{route('products.printercode',$row->codebar,'printercode')}}"
                                                       target="_blank"
                                                       class='btn btn-xs btn-primary' title='Imprimir código'><i
                                                                class='ace-icon fa fa-print'></i></a>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {!! $data->setPath(route('products.index'))->appends(Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <!-- FastClick -->
    <script src="{{URL::asset('/vendors/fastclick/lib/fastclick.js')}}"></script>
@endsection
