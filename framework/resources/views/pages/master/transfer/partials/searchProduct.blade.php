{{ Form::open(['url' => route('product.autocomplete'), 'method' => 'GET','class'=>'form-horizontal form-label-left']) }}
{{ csrf_field() }}
{{ Form::text('codebar', '', ['class'=>'form-control','autocomplete'=>'off', 'placeholder' =>  'Teclee un código para buscar'])}}
{{ Form::close() }}