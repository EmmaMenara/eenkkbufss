@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Cat&aacute;logos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-building-o"></i> Sucursales <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-plus-square"></i> Nuevo registro
@endsection
@section('content')
    {!! Form::open(['route' => 'branch.store', 'role' => 'form','method'=>'post',  'class' => 'form-horizontal form-label-left']) !!}
    @include('pages.master.branch.partial.fields')
    {!! Form::close() !!}
@endsection
