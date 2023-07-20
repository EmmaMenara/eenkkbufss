<h5>Datos de ubicaci&oacute;n</h5>
<fieldset>
    <legend></legend>
    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('address','',['class'=>'form-control has-feedback-left','placeholder'=>'Direcci&oacute;n'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('numberinner','',['class'=>'form-control has-feedback-left','placeholder'=>'No. interior'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('numberour','',['class'=>'form-control has-feedback-left','placeholder'=>'No. exterior'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('colony','',['class'=>'form-control has-feedback-left','placeholder'=>'Colonia'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('zip','',['class'=>'form-control has-feedback-left','placeholder'=>'C&oacute;digo postal'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('zip','',['class'=>'form-control has-feedback-left','placeholder'=>'Ciudad'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>

</fieldset>