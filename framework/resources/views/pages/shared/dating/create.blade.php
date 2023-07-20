@extends('layouts.app')
@push('header-scripts')
    <!-- Font Awesome -->
    <link href="{{ URL::asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- bootstrap-daterangepicker -->
    <link href="{{ URL::asset('plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="{{ URL::asset('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}"
          rel="stylesheet">
    <style>

        .daterangepicker .ranges li {
            color: #73879C
        }
        .daterangepicker .ranges li.active,
        .daterangepicker .ranges li:hover {
            background: #536A7F;
            border: 1px solid #536A7F;
            color: #fff
        }
        .daterangepicker .input-mini {
            background-color: #eee;
            border: 1px solid #ccc;
            box-shadow: none !important
        }
        .daterangepicker .input-mini.active {
            border: 1px solid #ccc
        }
        .daterangepicker select.monthselect,
        .daterangepicker select.yearselect,
        .daterangepicker select.hourselect,
        .daterangepicker select.minuteselect,
        .daterangepicker select.secondselect,
        .daterangepicker select.ampmselect {
            font-size: 12px;
            padding: 1px;
            height: auto;
            margin: 0;
            cursor: default;
            height: 30px;
            border: 1px solid #ADB2B5;
            line-height: 30px;
            border-radius: 0px !important
        }
        .daterangepicker select.monthselect {
            margin-right: 2%
        }
        .daterangepicker td.in-range {
            background: #E4E7EA;
            color: #73879C
        }
        .daterangepicker td.active,
        .daterangepicker td.active:hover {
            background-color: #536A7F;
            color: #fff
        }
        .daterangepicker th.available:hover {
            background: #eee;
            color: #34495E
        }
        .daterangepicker:before,
        .daterangepicker:after {
            content: none
        }
        .daterangepicker .calendar.single {
            margin: 0 0 4px 0
        }
        .daterangepicker .calendar.single .calendar-table {
            width: 224px;
            padding: 0 0 4px 0 !important
        }
        .daterangepicker .calendar.single .calendar-table thead tr:first-child th {
            padding: 8px 5px
        }
        .daterangepicker .calendar.single .calendar-table thead th {
            border-radius: 0
        }
        .daterangepicker.picker_1 {
            color: #fff;
            background: #34495E
        }
        .daterangepicker.picker_1 .calendar-table {
            background: #34495E
        }
        .daterangepicker.picker_1 .calendar-table thead tr {
            background: #213345
        }
        .daterangepicker.picker_1 .calendar-table thead tr:first-child {
            background: #1ABB9C
        }
        .daterangepicker.picker_1 .calendar-table td.off {
            background: #34495E;
            color: #999
        }
        .daterangepicker.picker_1 .calendar-table td.available:hover {
            color: #34495E
        }
        .daterangepicker.picker_2 .calendar-table thead tr {
            color: #1ABB9C
        }
        .daterangepicker.picker_2 .calendar-table thead tr:first-child {
            color: #73879C
        }
        .daterangepicker.picker_3 .calendar-table thead tr:first-child {
            color: #fff;
            background: #1ABB9C
        }
        .daterangepicker.picker_4 .calendar-table thead tr:first-child {
            color: #fff;
            background: #34495E
        }
        .daterangepicker.picker_4 .calendar-table td,
        .daterangepicker.picker_4 .calendar-table td.off {
            background: #ECF0F1;
            border: 1px solid #fff;
            border-radius: 0
        }
        .daterangepicker.picker_4 .calendar-table td.active {
            background: #34495E
        }
        .calendar-exibit .show-calendar {
            float: none;
            display: block;
            position: relative;
            background-color: #fff;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            overflow: hidden
        }
        .calendar-exibit .show-calendar .calendar {
            margin: 0 0 4px 0
        }
        .calendar-exibit .show-calendar.picker_1 {
            background: #34495E
        }
        .calendar-exibit .calendar-table {
            padding: 0 0 4px 0
        }
    </style>
@endpush
@section('title')
    <i class="fa fa-calendar-plus-o"></i> Citas <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-plus-square"></i> Generar
@endsection
@section('content')
    {!! Form::open(['url' => route('dating.store'), 'method' => 'post','class'=>'form-horizontal form-label-left']) !!}
    @include('pages.shared.dating.partial.fields')
    {!! Form::close() !!}
@endsection

@push('scripts')
    <!-- bootstrap-daterangepicker -->
    <script src="{{ URL::asset('plugins/momentjs/moment.js') }}"></script>
    <script src="{{URL::asset('plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->
    <script src="{{URL::asset('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>

        $('#myDatepicker3').datetimepicker({
            format: 'HH:mm'
        });

        $('#myDatepicker2').datetimepicker({
            format: 'DD-MM-YYYY'
        });

        function checkAppointments() {
            var id = $('select[name=barber_id]').val();
            var value = $('input[name=startDate]').val();
            console.log(value);
            if (id != '') {
                $.ajax({
                    type: 'GET',
                    url: "{{route('barber.check-appointments')}}",
                    data: {
                        '_token': $('meta[name=_token]').attr('content'), 'id': id, 'value': value,
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (excep) {
                        console.log(excep);
                    }
                });
            } else {
                alert('Seleccione un barbero.');
            }

        }

    </script>
@endpush
