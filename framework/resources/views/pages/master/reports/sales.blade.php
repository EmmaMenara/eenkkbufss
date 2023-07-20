@extends('layouts.app')
@section('title')
    <i class="fa fa-th-list"></i> Reportes <i class="fa fa-angle-double-right"></i> <i
            class="fa fa-credit-card"></i> Sales
@endsection
@push('header-scripts')
    <!-- bootstrap-datetimepicker -->
    <link href="{{URL::asset('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}"
          rel="stylesheet">
    <script src="{{URL::asset('lib/validatorFields.js')}}"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-2 col-sm-12 col-xs-12">
            <h3 style="margin-top: 3px!important;">{{\Auth::user()->NameBranch->name}}</h3>
        </div>
        <div class="col-md-5 col-sm-12 col-xs-12">
            <div class="form-group">
                <h4>Corte de caja&nbsp;&nbsp;&nbsp;<small>Del {{date('d-m-Y',strtotime($home))}}
                        al {{date('d-m-Y',strtotime($end))}}</small>
                </h4>
            </div>
        </div>
        <div class="col-md-5 col-sm-12 col-xs-12">
            @include('pages.master.reports.partial.rangeDate',['path'=>route('reports.sales')])
        </div>
    </div>

    <div class="row">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-money"></i>
                </div>
                <div class="count" style="font-size: 30px!important;">
                    ${{number_format($efectivo,2)}}</div>
                <h3><br/>Efectivo</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-paperclip"></i>
                </div>
                <div class="count" style="font-size: 30px!important;">
                    ${{number_format($clip,2)}}</div>
                <h3><br/>Fiados</h3>
            </div>
        </div>


        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats bg-blue-sky">
                <div class="icon text-success" style="color:white!important;"><i
                            class="fa fa-dollar"></i>
                </div>
                <div class="count" style="font-size: 30px!important;">
                    ${{number_format($total,2)}}</div>
                <h3><br/><span style="color:white!important;">Total</span></h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12"><br/>
            <a href="{{route('reports.sales')}}?home={{date('d-m-Y',strtotime($home))}}&end={{date('d-m-Y',strtotime($end))}}"
               target="_blank">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-print"></i>
                    </div>
                    <div class="count" style="font-size: 30px!important;">Imprimir</div>
                    <h3 style="font-weight: bold!important;">Ticket</h3>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
    <table class="table">
        <thead>
        <tr>
            <th>Folio</th>
            <th>Fecha - Hora</th>
            <th>Usuario</th>
            <th>Tipo de venta</th>{{--
            <th style="text-align: right">Subtotal</th>
            <th style="text-align: right">I.V.A.</th>--}}
            <th style="text-align: right">Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $granTotal = 0;
        ?>
        @foreach($data as $row)
            @if($row->status!='nueva')
                <tr>
                    <td> {{str_pad($row->id,10, "0",STR_PAD_LEFT)}}</td>
                    <td>{{$row->created_at}}</td>
                    <td>{{$row->createUser}}</td>
                    <td>{{$row->method_payment}}</td>{{--
                    <td style="text-align: right">${{number_format($row->subtotal,2)}}</td>
                    <td style="text-align: right">${{number_format($row->iva,2)}}</td>--}}
                    <td style="text-align: right">
                        ${{number_format(($row->mount),2)}}</td>
                    <?php $granTotal += ($row->mount);?>
                </tr>
            @endif
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4" style="text-align: right">Gran total</th>
            <th style="text-align: right">${{number_format($granTotal,2)}}</th>
        </tr>
        </tfoot>
    </table>
    </div>
    <div class="row">

        <table class="table">
            <caption class="text-center"><span class="label-danger"
                                               style="color: white!important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Folios cancelados &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </caption>
            <thead>
            <tr>
                <th>Folio</th>
                <th>Fecha - Hora</th>
                <th>Usuario</th>
                <th>Forma de pago</th>
                <th style="text-align: right">Subtotal</th>
                <th style="text-align: right">I.V.A.</th>
                <th style="text-align: right">Total</th>
                <th>Fecha cancelaci&oacute;n</th>
                <th>Cancelada por</th>
            </tr>
            </thead>
            <tbody>
            <?php $granTotal = 0;
            ?>
            @foreach($data as $row)
                @if($row->cancel==1)
                    <tr>
                        <td>{{str_pad($row->folio,10, "0",STR_PAD_LEFT)}}</td>
                        <td>{{$row->created_at}}</td>
                        <td>{{$row->vendedor}}</td>
                        <td>{{$row->methodpayment}}</td>
                        <td style="text-align: right">${{number_format($row->subtotal,2)}}</td>
                        <td style="text-align: right">${{number_format($row->iva,2)}}</td>
                        <td style="text-align: right">
                            ${{number_format(($row->subtotal+$row->iva),2)}}</td>
                        <td>{{$row->cancel_at}}</td>
                        <td>{{$row->user_cancel}}</td>
                        <?php $granTotal += ($row->subtotal + $row->iva);?>
                    </tr>
                @endif
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="8" style="text-align: right">Gran total</th>
                <th style="text-align: right">${{number_format($granTotal,2)}}</th>
            </tr>
            </tfoot>
        </table>
    </div>



@endsection
@push('scripts')
    <!-- bootstrap-daterangepicker -->
    <script src="{{URL::asset('plugins/momentjs/moment.js')}}"></script>
    <script src="{{URL::asset('plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!-- bootstrap-datetimepicker -->
    <script src="{{URL::asset('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $("form").keypress(function (e) {
                if (e.which == 13) {
                    return false;
                }
            });

            $('input[name=home]').daterangepicker({
                singleDatePicker: true,
                singleClasses: "picker_4",
                locale: {
                    format: 'DD-MM-YYYY'
                },
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });

            $('input[name=end]').daterangepicker({
                singleDatePicker: true,
                singleClasses: "picker_4",
                locale: {
                    format: 'DD-MM-YYYY'
                },
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });

    </script>
@endpush