@if(isset($data->id))
    {!! Form::hidden('id',isset($data->id) ? ($data->id) : '') !!}
@endif
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('name',isset($data->name) ? ($data->name) : '',['required'=>"required",'class'=>"form-control col-md-7 col-xs-12"]) !!}
        @if ($errors->has('name'))
            <div class="alert-error">
                <strong>{{ $errors->first('name') }}</strong>
            </div>
        @endif
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Dirección <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('direction',isset($data->direction) ? old($data->direction) : '',['required'=>"required",'class'=>"form-control col-md-7 col-xs-12"]) !!}
        @if ($errors->has('direction'))
            <div class="alert-error">
                <strong>{{ $errors->first('direction') }}</strong>
            </div>
        @endif
    </div>
</div>
<div class="ln_solid"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a href="{{route('branch.index')}}" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Registrar</button>
    </div>
</div>
