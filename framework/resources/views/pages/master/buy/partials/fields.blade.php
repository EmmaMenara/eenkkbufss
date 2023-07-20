<div class="row">
    <div class="col-md-2 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="control-label">Fecha de compra <span
                        class="required">*</span></label>
            <div class='input-group date'>
                <input type='text' class="form-control" value="{{isset($data->date_buy) ? date('d-m-Y',strtotime($data->date_buy. "00:00:00")) : date ('d-m-y')}}"
                       name="compra" readonly style="cursor: pointer!important;"/>
                <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-12 col-xs-12">
        <label class="control-label text-right">No. de documento </label>
        <div>
            {!! Form::text('numero',0,['maxlength'=>'15','class'=>"form-control text-right","onkeyup"=>"updatenumero()"]) !!}
            @if ($errors->has('num_docto'))
                <div class="alert-error">
                    <strong>{{ "Campo obligatorio"}}</strong>
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="control-label">Proveedor <span
                        class="required">*</span></label>
            <div class=" ">
                <select class="form-control" name="proveedor" onchange="seleccionarProveedor();">
                    <option value=" ">Seleccionar...</option>
                    @foreach($supplier as $row)
                        <option value="{{$row->id}}">{{$row->provider_name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('supplier_id'))
                    <div class="alert-error">
                        <strong>{{ "Campo obligatorio"}}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2 col-sm-12 col-xs-12">
        <label class="control-label text-right">Cantidad <span class="required">*</span></label>
        <div>
            {!! Form::text('quantity',0,['onkeypress'=>'return FenixNumeric(event,this);','maxlength'=>'3','required'=>"required",'class'=>"form-control text-right", 'onclick'=>"selectControl('quantity');"]) !!}
        </div>
    </div>
    <div class="col-md-5 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="control-label   text-right">C&oacute;digo de barras <span class="required">*</span></label>
            <div>
                @include('pages.master.buy.partials.searchProduct')
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="control-label text-right">Costo unitario<span
                        class="required">*</span>
            </label>
            <div>
                {!! Form::text('unit_cost',0,['required'=>"required",'class'=>"form-control",'style'=>'text-align: right;']) !!}
                @if ($errors->has('unit_cost'))
                    <div class="alert-error">
                        <strong>{{ $errors->first('unit_cost') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="control-label text-right">Precio de venta<span
                        class="required">*</span>
            </label>
            <div>
                {!! Form::text('unit_price',0,['required'=>"required",'class'=>"form-control",'style'=>'text-align: right;']) !!}
                @if ($errors->has('unit_price'))
                    <div class="alert-error">
                        <strong>{{ $errors->first('unit_price') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-1 col-sm-12 col-xs-12">
        {!! Form::hidden('codeHidden',0) !!}
        <div class="form-group"><br/>
            <button class="btn-warning btn-sm" onclick="loadData();">Agregar</button>
        </div>
    </div>
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
            <th>Código interno</th>
            <th>Producto</th>
            <th class="text-center">Costo unitario</th>
            <th class="text-center">Precio de venta</th>
            <th class="text-center">Importe</th>
            <th>Acci&oacute;n</th>
        </tr>
        </thead>
        <tbody>
        @php $granTotal=0; @endphp
        @foreach($data->products as $row)
            <tr>
                <td>{{$row->pivot->quantity}}</td>
                <td>{{$row->codebar}}</td>
                <td>{{$row->codeinner}}</td>
                <td>{{$row->name}}</td>
                <td class="text-right">${{number_format($row->pivot->unitcost,2)}}</td>
                <td class="text-right">${{number_format($row->pivot->unitpricesale,2)}}</td>
                <td class="text-right">${{number_format(($row->pivot->quantity * $row->pivot->unitcost),2)}}</td>
                <td>
                    <form method='POST' action="{{route('buy.destroy',$row->id)}}"
                          accept-charset='UTF-8'><input name='_method' type='hidden'
                                                        value='DELETE'>
                        {{csrf_field()}}
                        <button type='submit' class='btn btn-xs btn-danger'
                                onclick="return confirm('¿Desea eliminar el producto {{$row->name}}?');"
                                title='Eliminar'><i class='ace-icon fa fa-trash-o'></i></button>
                    </form>
                </td>
            </tr>
            @php $granTotal+=($row->pivot->quantity * $row->pivot->unitcost); @endphp
        @endforeach
        </tbody>
    </table>
</div>
<div class="ln_solid"></div>
{!! Form::open(['url' => route('buy.store'), 'method' => 'post','class'=>'form-horizontal form-label-left']) !!}
{{Form::hidden('supplier_id','')}}
{!! Form::hidden('date_buy',isset($data->date_buy) ? date('Y-m-d',strtotime($data->date_buy. "00:00:00")) : date ('Y-m-d')) !!}
{{Form::hidden('num_docto','')}}
<div class="form-group">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-4">
            <h3 class="total">Costo de inversión: $<span id="total-num">{{number_format($granTotal,2)}}</span></h3>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4" style="display: none!important;">
            <h3 class="total">Costo al público: $<span id="total-global">0</span></h3>
            <input type="hidden" name="mount-global" id="mount-global" value="0"/>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4 text-right">
            @if(count($data->products)>0)
                <a href="{{route('buy.index')}}" class="btn btn-primary">Cancelar</a>
                <button type="submit" class="btn btn-success">Registrar</button>
            @endif
        </div>
    </div>
</div>
{!! Form::close() !!}
