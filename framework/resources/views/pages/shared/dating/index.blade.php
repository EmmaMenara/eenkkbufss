@extends('layouts.app')
@push('header-scripts')
    <script src="{{ URL::asset('plugins/fullcalendar/lib/jquery.min.js') }}"></script>
    <link href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet">
@endpush
@section('title')
    <i class="fa fa-folder"></i> Citas
@endsection
@section('search')
    <div class="col-md-3 col-sm-12 col-xs-12">
        <a href="{{route('dating.create')}}" class="btn btn-primary btn-small">Agendar</a>
    </div>
@endsection

@section('content')
    <div class="row">
        @include('partials._alerts')
    </div>
    {!! $calendar->calendar() !!}
    {!! $calendar->script() !!}

@endsection

@push('scripts')

    <!-- Moment Plugin Js -->
    <script src="{{ URL::asset('plugins/momentjs/moment.js') }}"></script>

    <script src="{{ URL::asset('plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/fullcalendar/locale/es.js') }}"></script>
@endpush