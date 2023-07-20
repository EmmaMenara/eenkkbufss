@extends('layouts.app')
@section('title')
    <i class="fa fa-folder"></i> Cat&aacute;logos <i class="fa fa-angle-double-right"></i>
    <i class="fa fa-barcode"></i> Productos <i class="fa fa-angle-double-right"></i>
    <i class="fa fa-upload"></i>Carga masiva
@endsection

@push('header-scripts')
@endpush
@section('content')
    @include('partials._alerts')
    <div class="row">
        @if(Session::has('incidence'))
            <div class="col-md-12">
                <div class="alert alert-danger">
                    {{Session::get('incidence')}}
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <small><strong>Nota: </strong>Cada producto registrado, autom&aacute;ticamente ingresa al catálogo sin afectar existencias.</small>
        <br/></br>
    </div>
    <div class="clearfix"></div>

    @include('pages.master.product.partial.template')

@endsection