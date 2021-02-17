@extends('layouts.adminlte.template')
@section('title', 'Summary of Actual Disbursement')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />

@endpush
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Summary of Actual Disbursement</h3>
    </div>
    <div class="card-body">

        <table id="expensesList" class="table table-sm table-bordered table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Region</th>
                    <th>Province/District</th>
                    <th class="sum">Elementary</th>
                    <th class="sum">High School</th>
                    <th class="sum">Vocational</th>
                    <th class="sum">College</th>
                    <th class="sum">Post Study</th>
                    <th class="sum">Administrative Cost</th>
                    <th class="sum">Actual Amount Disburse to Grantees</th>
                    <th class="sum">Total</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $expense)
                <tr>
                    <td>{{ App\Models\Psgc::getRegion($expense->province) }}</td>
                    <td>{{ App\Models\Psgc::getProvince($expense->province) }}</td>
                    <td class="text-center">
                        @foreach($level['elementary'] as $elementary)
                        @if($elementary->province == $expense->province)
                        {{ $elementary->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['highSchool'] as $highSchool)
                        @if($highSchool->province == $expense->province)
                        {{ $highSchool->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['vocational'] as $vocational)
                        @if($vocational->province == $expense->province)
                        {{ $vocational->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['college'] as $college)
                        @if($college->province == $expense->province)
                        {{ $college->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['postStudy'] as $postStudy)
                        @if($postStudy->province == $expense->province)
                        {{ $postStudy->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($adminCosts as $adminCost)
                        @if($adminCost->province == $expense->province)
                        {{ number_format($adminCost->amount, 2, '.', ',') }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($actualPayments as $actualPayment)
                        @if($actualPayment->province == $expense->province)
                        {{ number_format($actualPayment->amount, 2, '.', ',') }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['total'] as $total)
                        @if($total->province == $expense->province)
                        {{ $total->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right"></th>
                    <th class="text-right">TOTAL:</th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-center"></th>
                    <th class="text-right"></th>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#expensesList').DataTable({
            "fixedHeader": {
                header: true,
                footer: true
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],

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
                title: 'SUMMARY OF ACTUAL DISBURSEMENT (FORM F)',
                extend: 'excelHtml5',
                footer: true,
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                }
            }, {
                extend: 'print',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                },
                autoPrint: false,
                title: '',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                },
                messageTop: '<div class="row">' +
                    '<div class="col-4">' +
                    '<img src="/images/app/NCIP_logo150x150.png" style="width:100px; height:100px; float:right;" />' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-center">Republic of the Philippines<br>Office of the President<br><strong>NATIONAL COMMISSION ON INDIGENOUS PEOPLES</strong><br>' +
                    '{{ App\Models\Psgc::getRegion(Auth::user()->region) }}<br><br>' +
                    '<strong>SUMMARY OF ACTUAL DISBURSEMENT</strong><br> ' +
                    'School Year ____ <br>' +
                    'As of {{now()}}</p>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-right">Form F</p>' +
                    '</div>' +
                    '</div>',

                messageBottom: '<div class="row mt-5">' +
                    '<div class="col-1">' +
                    '</div>' +
                    '<div class="col-3">' +
                    '<p class="text-left">Prepared by:<br><br>NAME NAME NAME<br>' +
                    'Position<br><br>' +
                    '</div>' +
                    '<div class="col-3">' +
                    '</div>' +
                    '<div class="col-3">' +
                    '<p class="text-left">Reviewed by:<br><br>NAME NAME NAME<br>' +
                    'Position<br><br>' +
                    '</div>' +
                    '<div class="col-2">' +
                    '</div>' +
                    '</div>',

                customize: function(win) {

                    var css = '@page { size: landscape; } table tfoot { display: table-row-group; }',
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

                    $(win.document.body).find('table tbody td').css({
                        'text-align': 'center'
                    });
                    $(win.document.body).find('table tbody td:nth-child(8)').css('text-align', 'right');
                    $(win.document.body).find('table tbody td:nth-child(9)').css('text-align', 'right');

                    $(win.document.body).find('table tfoot th').css({
                        'vertical-align': 'middle',
                        'text-align': 'center'
                    });
                    $(win.document.body).find('table tfoot th:nth-child(2)').css('text-align', 'right');
                    $(win.document.body).find('table tfoot th:nth-child(8)').css('text-align', 'right');
                    $(win.document.body).find('table tfoot th:nth-child(9)').css('text-align', 'right');

                }
            }, 'colvis']

        });

    });
</script>
@endpush