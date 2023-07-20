<h5>Contacto</h5>
<fieldset>
    <legend></legend>
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('name','',['class'=>'form-control has-feedback-left','placeholder'=>'Cargo'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('name','',['class'=>'form-control has-feedback-left','placeholder'=>'Nombre'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('firts_name','',['class'=>'form-control has-feedback-left','placeholder'=>'Primer apellido'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('second_name','',['class'=>'form-control has-feedback-left','placeholder'=>'Segundo apellido'])}}
            <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>

    <div class="row">

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('email','',['class'=>'form-control has-feedback-left','placeholder'=>'E-mail'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('phone','',['class'=>'form-control has-feedback-left','placeholder'=>'Tel&eacute;fono'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group has-feedback">
            {{Form::text('email','',['class'=>'form-control has-feedback-left','placeholder'=>'Celular'])}}
            <span class="fa fa-check-circle-o form-control-feedback left" aria-hidden="true"></span>
        </div>

    </div>
    <div class="row">
        <label class="text-primary">&nbsp;&nbsp;&nbsp;Despu&eacute;s de almacenar el registro podrá añadir más contactos.</label>
    </div>
</fieldset>
