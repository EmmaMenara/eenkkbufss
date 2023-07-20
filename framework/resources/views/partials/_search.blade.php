{!! Form::open(['url' => $path, 'method' => 'get']) !!}
<div class="title_right">
    @if(isset($msg))
    <div class="col-md-6 col-sm-12 col-xs-12 form-group pull-right ">
    <small class="title_right">Código de barras | Nombre</small><br/>
        <span style="color: #E9EDEF!important;
    background-color: rgba(231, 76, 60, 0.88)!important;
    border-color: rgba(231, 76, 60, 0.88)!important;font-weight: bold!important;">
                DEBAJO DEL STOCK MINIMO
            </span><br/>
        <span style="color: #E9EDEF!important;
    background-color: rgba(243, 156, 18, 0.88)!important;
    border-color: rgba(243, 156, 18, 0.88)!important;font-weight: bold!important;">
                IGUAL AL STOCK MÍNIMO
            </span>
        <span style="   color: #E9EDEF!important;
    background-color: rgba(52, 152, 219, 0.88)!important;
    border-color: rgba(52, 152, 219, 0.88)!important;font-weight: bold!important;">
                EXISTENCIAS
            </span>
    </div>
    @endif
    <div class="col-md-5 col-sm-12 col-xs-12 form-group pull-right top_search">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Teclee un texto..." value="{{$search}}">
            <span class="input-group-btn"><button class="btn btn-default" type="submit">Buscar</button></span>
        </div>
    </div>


</div>
{!! Form::close() !!}

