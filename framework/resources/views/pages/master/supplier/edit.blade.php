@extends('layouts.app')
@push('header-scripts')
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
    <link href="{{asset('plugins/jquery-steps/jquery.steps.css')}}" rel="stylesheet">
@endpush
@section('title')
    <i class="fa fa-folder"></i> Cat&aacute;logos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-truck"></i> Proveedores <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-edit"></i> Editar registro
@endsection

@section('content')

    {!! Form::model($data,['route' => ['provider.update',$data->id], 'method' => 'put','class'=>'form-horizontal form-label-left']) !!}
    @include('pages.master.supplier.partial.fields')
    {!! Form::close() !!}

@endsection

@push('scripts')
    <!-- Moment Plugin Js -->
    <script src="{{ URL::asset('plugins/momentjs/moment.js') }}"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ URL::asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <!-- Autosize Plugin Js -->
    <script src="{{ URL::asset('plugins/autosize/autosize.js') }}"></script>
    <!-- Validation Plugin Js -->
    <script src="{{ URL::asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ URL::asset('plugins/jquery-validation/additional-methods.js') }}"></script>
    <!-- Jquery Steps Js -->
    <script src="{{ URL::asset('plugins/jquery-steps/jquery.steps.js') }}"></script>
    <script>

        $.AdminBSB = {};

        $.AdminBSB.input = {
            activate: function () {
                //On focus event
                $('.form-control').focus(function () {
                    $(this).parent().addClass('focused');
                });

                //On focusout event
                $('.form-control').focusout(function () {
                    var $this = $(this);
                    if ($this.parents('.form-group').hasClass('form-float')) {
                        if ($this.val() == '') { $this.parents('.form-line').removeClass('focused'); }
                    }
                    else {
                        $this.parents('.form-line').removeClass('focused');
                    }
                });

                //On label click
                $('body').on('click', '.form-float .form-line .form-label', function () {
                    $(this).parent().find('input').focus();
                });
            }
        }


    </script>
@endpush