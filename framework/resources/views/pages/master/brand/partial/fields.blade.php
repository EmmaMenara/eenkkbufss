@if(isset($data->id))
    {!! Form::hidden('id',isset($data->id) ? old($data->id) : '') !!}
@endif
<?php
$name='';
if(isset($data)){
    $name=$data->name;
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
                        {{Form::text('name',isset($name) ? old($name) : $name,['class'=>'form-control has-feedback-left','maxlength'=>"30",'placeholder'=>'Nombre'])}}
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('name'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                 </div>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                <a href="{{route('brand.index')}}" type="button" class="btn btn-primary">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </div>
    </div>
</div>