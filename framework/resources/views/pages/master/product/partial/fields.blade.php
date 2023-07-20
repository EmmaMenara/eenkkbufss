@if(isset($id))
    {!! Form::hidden('id',isset($id) ? ($id) : '') !!}
@endif
<?php
$genero = '';
$tipo = '';
$talla = '';
$color = '';
$codebar = '';
$name = '';
$price = '';
$stockmin = '';
$stockmax = '';
$codeinner = '';
$costo = '';
//$brand_id = '';
if (isset($data)) {
    $genero = $data->genero;
    $tipo = $data->tipo;
    $talla = $data->talla;
    $color = $data->color;
    $codebar = $data->codebar;
    $codeinner = $data->codeinner;
    $name = $data->name;
    $costo = $data->costo;
    $stockmin = $data->stock_min_matriz;
    $stockmax = $data->stock_max_matriz;
    $brand_id = $data->brand_id;
    foreach ($data->detailsData(1)->get() as $item) {
        //dd($item->pivot);//->branch_id);
        if ($item->pivot->branch_id == 1) {
            //dd("entre");
            $price = $item->pivot->unitprice1;
            break;
        }
    }

//    dd($codebar,$name,$price,$stockmin,$stockmax);
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
                    {{--                <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                                        {{Form::text('business',isset($business) ? ($business) : $business,['class'=>'form-control has-feedback-left','placeholder'=>'Negocio','maxlength'=>"25" ])}}
                                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                                        @if ($errors->has('codebar'))
                                            <div class="alert-error">
                                                <strong>{{ $errors->first('codebar') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                --}}
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        <select class="form-control" name="brand_id">
                            <option value=" ">Seleccionar marca...</option>
                            @foreach($brands as $row)
                                @if (Old('brand_id') == $row->id)
                                    <option value="{{$row->id}}" selected>{{$row->name}}</option>
                                @else
                                    @if(isset($brand_id))
                                        @if($brand_id==$row->id)
                                            <option value="{{$row->id}}" selected>{{$row->name}}</option>
                                        @else
                                            <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endif
                                    @else
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endif
                                @endif

                            @endforeach
                        </select>
                        <span>Marca</span>
                        @if ($errors->has('brand_id'))
                            <div class="alert-error">
                                <strong>{{ "La marca es un campo obligatorio." }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">

                        {{Form::text('codebar',isset($codebar) ? ($codebar) : $codebar,['class'=>'form-control has-feedback-left','placeholder'=>'Código barras','maxlength'=>"13",'onkeypress'=>'return FenixNumeric(event,this);','onkeyup'=>'FenixZero(event,this)'])}}
                        <span>C&oacute;digo de barras</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('codebar'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('codebar') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('codeinner',isset($codeinner) ? ($codeinner) : $codeinner,['class'=>'form-control has-feedback-left','placeholder'=>'Código interno','maxlength'=>"13"])}}
                        <span>C&oacute;digo interno</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('codeinner'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('codeinner') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        <span><strong>Los productos se agregan a nuestro almac&eacute;n principal llamado Matriz. para poder ser trasladados a las sucursales.</strong></span>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('name',isset($name) ? ($name) : $name,['class'=>'form-control has-feedback-left','placeholder'=>'Nombre','maxlength'=>"30",'onkeypress'=>'return FenixText(event,this);'])}}
                        <span>Nombre</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('name'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('genero',isset($genero) ? ($genero) : $genero,['class'=>'form-control has-feedback-left text-right','placeholder'=>'Género','maxlength'=>"30"])}}
                        <span>G&eacute;nero</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('genero'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('genero') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('tipo',isset($tipo) ? ($tipo) : $tipo,['class'=>'form-control has-feedback-left text-right','placeholder'=>'Tipo','maxlength'=>"30"])}}
                        <span>Tipo</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('tipo'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('tipo') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('color',isset($color) ? ($color) : $color,['class'=>'form-control has-feedback-left text-right','placeholder'=>'Color','maxlength'=>"30"])}}
                        <span>Color</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('color'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('color') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('talla',isset($talla) ? ($talla) : $talla,['class'=>'form-control has-feedback-left text-right','placeholder'=>'Talla','maxlength'=>"30"])}}
                        <span>Talla</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('talla'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('talla') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('costo',isset($costo) ? ($costo) : $costo,['class'=>'form-control has-feedback-left text-right','placeholder'=>'Costo','maxlength'=>"10",'onkeypress'=>'return FenixFloat(event,this);','onkeyup'=>'FenixZero(event,this)'])}}
                        <span>Costo</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('costo'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('costo') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('price',isset($price) ? ($price) : $price,['class'=>'form-control has-feedback-left text-right','placeholder'=>'Precio de venta','maxlength'=>"10",'onkeypress'=>'return FenixFloat(event,this);','onkeyup'=>'FenixZero(event,this)'])}}
                        <span>Precio de venta</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('price'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('price') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('stockmin',isset($stockmin) ? ($stockmin) : $stockmin,['class'=>'form-control has-feedback-left text-right','maxlength'=>"3",
                        'placeholder'=>'Stock mínimo','onkeypress'=>'return FenixNumeric(event,this);','onkeyup'=>'FenixZero(event,this)'])}}
                        <span>Stock m&iacute;nimo</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('stockmin'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('stockmin') }}</strong>
                            </div>
                        @endif

                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::text('stockmax',isset($stockmax) ? ($stockmax) : $stockmax,['class'=>'form-control has-feedback-left text-right','maxlength'=>"3",'placeholder'=>'Stock máximo','onkeypress'=>'return FenixNumeric(event,this);','onkeyup'=>'FenixZero(event,this)'])}}
                        <span>Stock m&aacute;ximo</span>
                        <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
                        @if ($errors->has('stockmax'))
                            <div class="alert-error">
                                <strong>{{ $errors->first('stockmax') }}</strong>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <span><strong>El Stock m&iacute;nimo y m&aacute;ximo, aplican para el almac&eacute;n principal llamado Matriz.
                         Si desea modificar &eacute;stos valores a una sucursal, favor de ir a la men&uacute; Configuraci&oacute;n.</strong></span>

                        <span><strong>El precio de venta establecido en la Matriz, será el mismo en la sucursales, en caso de que desee cambiar
                            precios en una sucursal, favor de ir al menú Configuración</strong></span>
                        @if(isset($data))
                            <span><strong>Actualizar el precio en esta ventana, afectará los precios en sucursales, hasta el momento en que se realice un traslado.</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                        {{Form::file('photo',['class'=>'form-control has-feedback-left'])}}
                        <span>Foto</span>
                        <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    @if(isset($data))
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                            <label>Imagen actual</label>
                            @include('pages.master.product.partial.preview',['photo'=>$data->photo])
                        </div>
                    @endif
                    <div class="col-md-3 col-sm-12 col-xs-12 text-right">
                        <a href="{{route('product.index')}}" type="button" class="btn btn-primary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">

        </div>
    </div>
</div>