<h5>Datos generales</h5>
<fieldset>
    <legend></legend>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('company','',['class'=>'form-control has-feedback-left','placeholder'=>'Empresa'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

    </div>

    <div class="row">
    {{--    <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('account','',['class'=>'form-control has-feedback-left','placeholder'=>'No. de cuenta'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('clabe','',['class'=>'form-control has-feedback-left','placeholder'=>'CLABE'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('email','',['class'=>'form-control has-feedback-left','placeholder'=>'E-mail'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>
--}}

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('rfc','',['class'=>'form-control has-feedback-left','placeholder'=>'R.F.C.'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('phone','',['class'=>'form-control has-feedback-left','placeholder'=>'Tel&eacute;fono'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>
</fieldset>
