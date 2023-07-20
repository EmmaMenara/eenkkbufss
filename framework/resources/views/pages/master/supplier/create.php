@extends('layouts.app')
@push('header-scripts')
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
    <link href="{{asset('plugins/jquery-steps/jquery.steps.css')}}" rel="stylesheet">
@endpush
@section('title')
    <i class="fa fa-folder"></i> Cat&aacute;logos <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-truck"></i> Proveedores <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-plus-square"></i> Nuevo registro
@endsection

@section('content')

    {!! Form::open(['route' => 'provider.index', 'role' => 'form', 'files' => 'true', 'id' => 'frmVisit']) !!}
    @include('pages.master.supplier.partial.step_one')
    @include('pages.master.supplier.partial.step_two')
    @include('pages.master.supplier.partial.step_three')
    {!! Form::close() !!}

@endsection

@push('scripts')
    <!-- Moment Plugin Js -->
    <script src="{{ URL::asset('plugins/momentjs/moment.js') }}"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ URL::asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <!-- Autosize Plugin Js -->
    <script src="{{ URL::asset('plugins/autosize/autosize.js') }}"></script>
    <!-- Validation Plugin Js -->
    <script src="{{ URL::asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ URL::asset('plugins/jquery-validation/additional-methods.js') }}"></script>
    <!-- Jquery Steps Js -->
    <script src="{{ URL::asset('plugins/jquery-steps/jquery.steps.js') }}"></script>
    <script>

        $.AdminBSB = {};

        $.AdminBSB.input = {
            activate: function () {
                //On focus event
                $('.form-control').focus(function () {
                    $(this).parent().addClass('focused');
                });

                //On focusout event
                $('.form-control').focusout(function () {
                    var $this = $(this);
                    if ($this.parents('.form-group').hasClass('form-float')) {
                        if ($this.val() == '') { $this.parents('.form-line').removeClass('focused'); }
                    }
                    else {
                        $this.parents('.form-line').removeClass('focused');
                    }
                });

                //On label click
                $('body').on('click', '.form-float .form-line .form-label', function () {
                    $(this).parent().find('input').focus();
                });
            }
        }

        $(function () {
            //Advanced form with validation
            var form = $('#frmVisit').show();
            form.steps({
                headerTag: 'h5',
                bodyTag: 'fieldset',
                transitionEffect: 'slideLeft',
                enableAllSteps: false,
                enablePagination: true,
                enableKeyNavigation: true,
                enableFinishButton: true,
                labels: {
                    cancel: "Cancelar",
                    current: "Paso actual:",
                    pagination: "Paginación",
                    finish: "Terminar",
                    next: ">>",
                    previous: "<<",
                    loading: "Cargando ..."
                },
                onInit: function (event, currentIndex) {
                    $.AdminBSB.input.activate();

                    //Set tab width
                    var $tab = $(event.currentTarget).find('ul[role="tablist"] li');
                    var tabCount = $tab.length;
                    $tab.css('width', (100 / tabCount) + '%');

                    //set button waves effect
                    setButtonWavesEffect(event);
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    if (currentIndex > newIndex) {
                        return true;
                    }
                    if (currentIndex < newIndex) {
                        form.find('.body:eq(' + newIndex + ') label.error').remove();
                        form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                    }

                    form.validate().settings.ignore = ':disabled,:hidden';
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex) {
                    setButtonWavesEffect(event);
                },
                onFinishing: function (event, currentIndex) {
                    form.validate().settings.ignore = ':disabled';
                    return form.valid();
                },
                onFinished: function (event, currentIndex) {
                    console.log("Good job!", "Submitted!", "success");
                    $("#frmVisit").submit()
                }
            });
        });

        $(function () {
            $.AdminBSB.input.activate();
            $("#tblSchedule tbody").on("click", "tr", function (event) {
                // Sets the date picker for all elements with the datepicker class.
                $('.datetimepicker').bootstrapMaterialDatePicker({
                    format: 'YYYY-MM-DD HH:mm:ss',
                    minDate: new Date(),
                    clearButton: true,
                    weekStart: 1,
                    shortTime: false
                }).change(function () {
                    if ($(this).val() !== '') {
                        focus(this);
                    } else {
                        defocus(this);
                    }
                });
            });

            $("#add_row_departure").click(function () {
                $('#departure_row' + i).html("<td>" + (i + 1) +"<td><input  name='duration[]' type='number' class='form-control' onkeypress ='return FenixNumeric(event,this);'></td>"+
                    "</td><td><input  name='visit_datetime[]' type='text' class='datetimepicker form-control'></td>");
                $('#tblSchedule').append('<tr id="departure_row' + (i + 1) + '"></tr>');
                i++;
            });
            $("#delete_row_departure").click(function () {
                if (i > 1) {
                    $("#departure_row" + (i - 1)).html('');
                    i--;
                }
            });

        });


        // Create dynamic table
        var i = 1;

        // Add class focused to an element to activate the corresponding effects.
        function focus(item) {
            var formLine = $(item).parent();
            formLine.addClass('focused');
        }

        // Remove class focused to an element to deactivate the corresponding effects.
        function defocus(item) {
            $(item).closest('.form-line').removeClass('focused');
        }


        function setButtonWavesEffect(event) {
            $(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
            $(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
        }
    </script>
@endpush