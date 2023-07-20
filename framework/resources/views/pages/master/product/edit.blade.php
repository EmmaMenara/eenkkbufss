@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Cat&aacute;logos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-barcode"></i> Productos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-edit"></i> Editar registro
@endsection
@push('header-scripts')
    <script src="{{asset('lib/validatorFields.js')}}"></script>
@endpush
@section('content')
    {!! Form::model($data,['route' => ['product.update',$data->id], 'method' => 'put',"enctype"=>"multipart/form-data",'class'=>'form-horizontal form-label-left']) !!}
    @include('pages.master.product.partial.fields')
    {!! Form::close() !!}
@endsection