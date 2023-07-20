@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Cat&aacute;logos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-users"></i> Fiados <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-plus-square"></i> Nuevo registro
@endsection
@section('content')
    {!! Form::open(['route' => 'customer.store', 'role' => 'form','method'=>'post',  'class' => 'form-horizontal form-label-left']) !!}
    @include('pages.master.customer.partial.fields')
    {!! Form::close() !!}
@endsection
