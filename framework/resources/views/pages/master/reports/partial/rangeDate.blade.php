{{ Form::open(['url' => $path, 'method' => 'POST','class'=>'form-horizontal form-label-left']) }}
{{ csrf_field() }}
<div class="row">
    <div class="col-md-10 col-sm-10 col-xs-12">
        <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Del <span
                        class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
                {!! Form::text('home',isset($home) ? old($home) : '',['required'=>"required",'class'=>"form-control"]) !!}
            </div>

            <label class="control-label col-md-2 col-sm-2 col-xs-12">Al <span
                        class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
                {!! Form::text('end',isset($end) ? old($end) : '',['required'=>"required",'class'=>"form-control"]) !!}
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
        <button type="submit" class="btn btn-warning">Buscar</button>
    </div>

</div>
{{ Form::close() }}