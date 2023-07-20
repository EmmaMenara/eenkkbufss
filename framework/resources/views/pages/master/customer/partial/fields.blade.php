@if(isset($id))
    {!! Form::hidden('id',isset($id) ? old($id) : '') !!}
@endif
<?php
$name='';
$first_surname='';
$second_surname='';
if(isset($data)){
    $name=$data->name;
    $first_surname=$data->first_surname;
    $second_surname=$data->second_surname;
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
                        <h4><span class="fa fa-ellipsis-h" aria-hidden="true">&nbsp;&nbsp;&nbsp;Opcionales</span>
                        </h4>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('name',isset($name) ? old($name) : $name,['class'=>'form-control has-feedback-left','placeholder'=>'Nombre'])}}
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('name'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('first_surname',isset($first_surname) ? old($first_surname) : $first_surname,['class'=>'form-control has-feedback-left','placeholder'=>'Primer apellido'])}}
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('first_surname'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('first_surname') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('second_surname',isset($second_surname) ? old($second_surname) : $second_surname,['class'=>'form-control has-feedback-left','placeholder'=>'Segundo apellido'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('second_surname'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('second_surname') }}</strong>
                            </div>
                        @endif
                    </div>

                </div>
{{--
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('nacimiento','',['class'=>'form-control has-feedback-left','placeholder'=>'Fecha de nacimiento'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('email','',['class'=>'form-control has-feedback-left','placeholder'=>'E-mail'])}}
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('mobile','',['class'=>'form-control has-feedback-left','placeholder'=>'Celular'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('beverage','',['class'=>'form-control has-feedback-left','placeholder'=>'Límite de crédito'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-9 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('address','',['class'=>'form-control has-feedback-left','placeholder'=>'Direcci&oacute;n'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('numberinner','',['class'=>'form-control has-feedback-left','placeholder'=>'No. interior'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('numberour','',['class'=>'form-control has-feedback-left','placeholder'=>'No. exterior'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('colony','',['class'=>'form-control has-feedback-left','placeholder'=>'Colonia'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('zip','',['class'=>'form-control has-feedback-left','placeholder'=>'C&oacute;digo postal'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('city','',['class'=>'form-control has-feedback-left','placeholder'=>'Ciudad'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::file('photo',['class'=>'form-control has-feedback-left'])}}
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"><br></span><label>Foto
                            del cliente</label><br/>
                    </div>
                </div>
--}}
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                <a href="{{route('customer.index')}}" type="button" class="btn btn-primary">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </div>
    </div>
</div>