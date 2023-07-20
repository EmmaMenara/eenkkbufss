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
                    </div>{{--
                        <div class="col-md-4 col-xs-12">
                            <h4><span class="fa fa fa-ellipsis-h" aria-hidden="true">&nbsp;&nbsp;&nbsp;Opcionales</span></h4>
                        </div>--}}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        <div class="form-group">
                            <div class="select2-search__field ">
                                <label>Cliente</label>
                                {{Form::select('customer_id',$customer,null,['class'=>'form-control','placeholder'=>'Seleccionar...'])}}
                                <span class="input-group-btn right"><span
                                            class="fa fa-check-circle-o"
                                            style="margin-left: 5px!important;margin-top: -25px!important;"></span></span>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        <div class="form-group">
                            <div class="select2-search__field ">
                                <label>Barbero</label>
                                {{Form::select('barber_id',$barber,null,['class'=>'form-control','placeholder'=>'Seleccionar...'])}}
                                <span class="input-group-btn right"><span
                                            class="fa fa-check-circle-o"
                                            style="margin-left: 5px!important;margin-top: -25px!important;"></span></span>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
                        <label>Seleccionar fecha</label>
                        <div class="form-group">
                            <div class="input-group date" id="myDatepicker2">
                                <input type="text" class="form-control" name="startDate"/>
                                <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 form-group"><br/>
                        <button class="btn btn-primary" onclick="checkAppointments();">Consultar agenda</button>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12 form-group has-feedback">
                        <div class="row">
                            <fieldset>
                                <legend>Citas agendas</legend>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-12 col-xs-12 form-group has-feedback">
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                        <div class="row">
                            <div class="row">
                                <fieldset>
                                    <legend>Agendar cita</legend>
                                </fieldset>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-12 col-xs-12 form-group has-feedback">
                                    <div class="form-group">
                                        <div class="select2-search__field ">
                                            <label>Servicio</label>
                                            {{Form::select('service_id',$service,null,['class'=>'form-control','placeholder'=>'Seleccionar...'])}}
                                            <span class="input-group-btn right"><span
                                                        class="fa fa-check-circle-o"
                                                        style="margin-left: 5px!important;margin-top: -25px!important;"></span></span>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <label>Indicar hora</label>
                                    <div class="form-group">
                                        <div class="input-group date" id="myDatepicker3">
                                            <input type="text" class="form-control" name="homeTime">
                                            <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <a href="{{route('product.index')}}" type="button" class="btn btn-primary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>