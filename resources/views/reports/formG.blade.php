@extends('layouts.adminlte.template')
@section('title', 'Actual Payments of Grantees')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">IP Educational Allowance</h3>
    </div>
    <div class="card-body">

        <table id="costList" class="table table-sm table-bordered table-hover table-responsive-sm" style="width:100%">
            <thead>
                <tr>
                    <th>Payee</th>
                    <th>Date of Payment</th>
                    <th class="sum">Amount</th>
                    <th>Mode of Payment/Reference No.</th>
                    <th>Province/District</th>
                    <th>Region</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $cost)
                <tr>
                    <td>{{ $cost->payee }}</td>
                    <td>{{ $cost->dateRcvd }}</td>
                    <td class="text-right">{{ number_format($cost->amount, 2, '.', ',') }}</td>
                    <td>{{ $cost->checkNo }}</td>
                    <td>{{ App\Models\Psgc::getProvince($cost->province) }}</td>
                    <td>{{ App\Models\Psgc::getRegion($cost->province) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th class="text-right">TOTAL:</th>
                    <th class="text-right"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
    <div class="card-footer">
        Footer
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#costList').DataTable({
            stateSave: true,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "order": [],

            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                api.columns('.sum', {
                    page: 'current'
                }).every(function() {
                    var pageSum = this
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    this.footer().innerHTML = pageSum.toLocaleString('us-US');
                });
            },

            dom: '<"row"<"col-md-12 mb-3"B>>' +
                '<"row"<"col-md-5"l><"col-md-7"f>>' +
                '<"row"<"col-md-12"t>>' +
                '<"row"<"col-md-5"i><"col-md-7"p>>' +
                '<"row"<"col-md-6"Q>>',

            buttons: [{
                filename: 'Actual_Payments_of_Grantees_(FORM_G)_{{ Auth::user()->name }}_{{ date('YmdHis') }}',
                title: '',
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                autoFilter: true,
                sheetName: 'IP Educational Allowance',
                footer: true,
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                }
            }, {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print', 
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                },
                autoPrint: false,
                title: '',
                footer: true,
                messageTop: '<div class="row">' +
                    '<div class="col-4">' +
                    '<img src="{{asset('/images/app/NCIP_logo150x150.png')}}" style="width:100px; height:100px; float:right;" />' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-center">Republic of the Philippines<br>Office of the President<br><strong>NATIONAL COMMISSION ON INDIGENOUS PEOPLES</strong><br>' +
                    '{{ App\Models\Psgc::getRegion(Auth::user()->region) }}<br><br>' +
                    '<strong>ACTUAL PAYMENTS OF GRANTEES</strong><br> ' +
                    'School Year ____ <br>' +
                    'As of {{now()}}</p>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-right">Form G</p>' +
                    '</div>' +
                    '</div>',

                messageBottom: '<div class="row mt-5">' +
                    '<div class="col-12">' +
                    '<p class="text-left text-sm">This report was generated using Educational Assistance Program Information System on {{ date('Y/m/d H:i:s') }} by {{ Auth::user()->name }};<p>' +
                    '</div>',

                customize: function(win) {
                    
                    var css = '@page { size: landscape; }',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body).find('table thead th').css({
                        'vertical-align': 'middle',
                        'text-align': 'center'
                    });

                    $(win.document.body).find('table tbody td:nth-child(3)').css('text-align', 'right');
                    $(win.document.body).find('table tfoot th:nth-child(2)').css('text-align', 'right');
                    $(win.document.body).find('table tfoot th:nth-child(3)').css('text-align', 'right');
                   
                }
            }, 'colvis']

        });

    });
</script>
@endpush