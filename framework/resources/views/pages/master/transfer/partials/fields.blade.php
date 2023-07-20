<div class="row">
    <div class="col-md-1 col-sm-12 col-xs-12">
        <label class="control-label text-right">Cantidad <span class="required">*</span></label>
        <div>
            {!! Form::text('quantity',0,['onkeypress'=>'return FenixNumeric(event,this);','maxlength'=>'3','required'=>"required",'class'=>"form-control text-right", 'onclick'=>"selectControl('quantity');"]) !!}
        </div>
    </div>
    <div class="col-md-7 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="control-label   text-right">C&oacute;digo de barras <span class="required">*</span></label>
            <div>
                @include('pages.master.transfer.partials.searchProduct')
            </div>
        </div>
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12">
        {!! Form::hidden('codeHidden',0) !!}
        <div class="form-group"><br/>
            <button class="btn-warning btn-sm" onclick="loadData();">Agregar</button>
        </div>
    </div>
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="control-label">Destino<span
                        class="required">*</span></label>
            <div class=" ">
                <select class="form-control" name="branch" onchange="seleccionarDestino();">
                    <option value=" ">Seleccionar...</option>
                    @foreach($branch as $row)
                        @if($row->id>1)
                            <option value="{{$row->id}}">{{$row->name}}</option>
                        @endif
                    @endforeach
                </select>
                @if ($errors->has('branch_id'))
                    <div class="alert-error">
                        <strong>{{ "Campo obligatorio"}}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">

</div>
<div class="row">

</div>

<div style="width:100%; height:280px; overflow: scroll; overflow-x: hidden;">
    <table id="productos" style="width: 100%!important;" class="table table-striped jambo_table bulk_action">
        {{--<caption class="text-center"><strong>El precio unitario es sin I.V.A.</strong> </caption>--}}
        <thead>
        <tr>
            <th class="text-center">Cant.</th>
            <th>Código de barras</th>
            <th>Producto</th>
            <th class="text-center">Precio de venta</th>
            <th class="text-center">Importe</th>
            <th class="text-center">Acci&oacute;n</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transfer->products as $row)
            <tr>
                <td>{{$row->pivot->quantity}}</td>
                <td>{{$row->codebar}}</td>
                <td>{{$row->name}}</td>
                <td class="text-right">${{number_format($row->pivot->unitpricesale,2)}}</td>
                <td class="text-right">${{number_format(($row->pivot->quantity*$row->pivot->unitpricesale),2)}}</td>
                <td class="text-center"><form method='POST' action="{{route('transfer.destroy',$row->id)}}"
                          accept-charset='UTF-8'><input name='_method' type='hidden'
                                                        value='DELETE'>
                        {{csrf_field()}}
                        <button type='submit' class='btn btn-xs btn-danger'
                                onclick="return confirm('¿Desea eliminar el producto {{$row->name}}?');"
                                title='Eliminar'><i class='ace-icon fa fa-trash-o'></i></button>
                    </form></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="ln_solid"></div>
{!! Form::open(['url' => route('transfer.store'), 'method' => 'post','class'=>'form-horizontal form-label-left']) !!}
{{Form::hidden('branch_id','')}}

<div class="form-group">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4" style="display: none!important;">
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4 text-right">
            <a href="{{route('transfer.index')}}" class="btn btn-primary">Cancelar</a>
            <button type="submit" class="btn btn-success">Registrar</button>
        </div>
    </div>
</div>
{!! Form::close() !!}
