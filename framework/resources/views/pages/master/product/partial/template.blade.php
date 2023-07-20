<div class="row">
    <div class="col-md-3 col-sm-3 col-xs-12">
        {!! Form::open(['url' => route('products.layout'), 'method' => 'post','class'=>'form-horizontal form-label-left']) !!}
        <button type="submit" class="btn btn-warning">Descargar layout</button>
        {!! Form::close() !!}
    </div>
    <div class="col-md-9 col-sm-9 col-xs-12">
        {!! Form::open(['url' => route('products.upload'), 'method' => 'post','class'=>'form-horizontal form-label-left',"enctype"=>"multipart/form-data"]) !!}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="margin-top:-5px">Cargar</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::file('file') !!}
                @if ($errors->has('file'))
                    <div class="alert-error">
                        <strong>{{ str_replace("xlsx","Microsoft Office Excel con extensión .xlsx",$errors->first('file'))  }}</strong>
                    </div>
                @endif

            </div>
        </div>
        <div class="row">

            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                    <a href="{{route('product.index')}}" class="btn btn-primary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Cargar</button>
                </div>
            </div>

        </div>
        {!! Form::close() !!}
    </div>

</div>
