{{ Form::open(['action' => ['master\SalesController@index'], 'method' => 'POST','class'=>'form-horizontal form-label-left']) }}
{{ csrf_field() }}
<div class="row">
    <div class="col-md-10 col-xs-10">
        {{ Form::text('search', '', ['class'=>'form-control','autocomplete'=>'off', 'placeholder' =>  'Teclee un texto'])}}
    </div>
    <div class="col-md-2 col-xs-1 offset1">
        <button type="submit" class="btn btn-success" style="margin-left: -10px!important;margin-top: 2px!important;"><i class="fa fa-search"></i></button>
    </div>
</div>

{{ Form::close() }}