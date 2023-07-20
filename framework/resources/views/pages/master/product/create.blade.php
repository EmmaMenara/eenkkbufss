@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Cat&aacute;logos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-barcode"></i> Productos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-plus-square"></i> Nuevo registro
@endsection
@push('header-scripts')
    <script src="{{asset('lib/validatorFields.js')}}"></script>
@endpush
@section('content')
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{route('products.layout')}}" class="btn btn-warning">Carga masiva</a>
    </div>
</div>
    {!! Form::open(['url' => route('product.store'), "enctype"=>"multipart/form-data", 'method' => 'post','class'=>'form-horizontal form-label-left']) !!}
    @include('pages.master.product.partial.fields',['brands'=>$brands])
    {!! Form::close() !!}
@endsection