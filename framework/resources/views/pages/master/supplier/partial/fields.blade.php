@if(isset($id))
    {!! Form::hidden('id',isset($id) ? ($id) : '') !!}
@endif
<?php
$company='';
$rfc='';
$phonenumber='';
$contactname='';
$contact_first_surname='';
$contact_second_surname='';
$mobile='';
if(isset($data)){
    $company=$data->provider_name;
    $rfc=$data->rfc;
    $phonenumber=$data->phone_number;
    $contactname=$data->contact_name;
    $contact_first_surname=$data->contact_first_surname;
    $contact_second_surname=$data->contact_second_surname;
    $mobile=$data->mobile;
}

?>

<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <h2>
                            <small>Datos generales</small>
                        </h2>
                    </div>
                    <div class="col-md-4 col-xs-12 text-right">
                        <h4 class="text-danger">Campos <span class="fa fa-check-circle-o" aria-hidden="true">&nbsp;&nbsp;&nbsp;Obligatorios</span>
                        </h4>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <h4><span class="fa fa fa-ellipsis-h" aria-hidden="true">&nbsp;&nbsp;&nbsp;Opcionales</span>
                        </h4>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">


                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">

                        {{Form::text('company',isset($company) ? $company : ($company),['class'=>'form-control has-feedback-left','placeholder'=>'Empresa'])}}

                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('company'))
                            <div class="alert-error">
                                <strong>{{ "La empresa es un campo obligatorio" }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('rfc',isset($rfc) ? $rfc : $rfc,['class'=>'form-control has-feedback-left','placeholder'=>'R.F.C.'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('phonenumber',isset($phonenumber) ? $phonenumber : ($phonenumber),['class'=>'form-control has-feedback-left','placeholder'=>'Tel&eacute;fono'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row">
                    <h2>
                        <small>Contacto</small>
                    </h2>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('name',isset($contactname) ? $contactname : ($contactname),['class'=>'form-control has-feedback-left','placeholder'=>'Nombre'])}}
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('name'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('first_surname',isset($contact_first_surname) ? $contact_first_surname : ($contact_first_surname),['class'=>'form-control has-feedback-left','placeholder'=>'Primer apellido'])}}
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('first_surname'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('first_surname') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('second_name',isset($contact_second_surname) ? $contact_second_surname : ($contact_second_surname),['class'=>'form-control has-feedback-left','placeholder'=>'Segundo apellido'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('mobile',isset($mobile) ? $mobile : ($mobile),['class'=>'form-control has-feedback-left','placeholder'=>'Celular'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>

                </div>


            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                <a href="{{route('provider.index')}}" type="button" class="btn btn-primary">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </div>
    </div>
</div>
