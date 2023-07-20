@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Cat&aacute;logos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-tag"></i> Marcas <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-edit"></i> Editar registro
@endsection
@section('content')
    {!! Form::model($data,['route' => ['brand.update',$data->id], 'method' => 'put','class'=>'form-horizontal form-label-left']) !!}
    @include('pages.master.brand.partial.fields')
    {!! Form::close() !!}
@endsection
