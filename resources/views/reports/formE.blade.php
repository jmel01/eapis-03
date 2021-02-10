@extends('layouts.adminlte.template')
@section('title', 'Report on Disbursement')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />

@endpush
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Report on Disbursement</h3>
    </div>
    <div class="card-body">

        <table id="costList" class="table table-sm table-bordered table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Payee</th>
                    <th>Particulars (Administrative Cost)</th>
                    <th>Amount</th>
                    <th>Province/District</th>
                    <th>Region</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $cost)
                <tr>
                    <td>{{ $cost->payee }}</td>
                    <td>{{ $cost->particulars }}</td>
                    <td class="text-right">{{ number_format($cost->amount, 2, '.', ',') }}</td>
                    <td>{{ App\Models\Psgc::getProvince($cost->province) }}</td>
                    <td>{{ App\Models\Psgc::getRegion($cost->province) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th class="text-right">Total:</th>
                    <th class="text-right"></th>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#costList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,

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

                // Total over all pages
                total = api
                    .column(2, {
                        page: 'all'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(2, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(2).footer()).html(
                    pageTotal.toLocaleString("en-US") + ' ( ' + total.toLocaleString("en-US") + ')'
                );
            },
            dom: 'BfrtipQ',
            buttons: [{
                title: 'Report on Disbursement-Administrative Cost (FORM E)',
                extend: 'excelHtml5',
                footer: true,
                exportOptions: {
                    columns: ':visible'

                }
            }, {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                },
                autoPrint: false,
                title: '',
                footer: true,
                messageTop: '<p class="text-right">Form E</p><p class="text-center">Republic of the Philippines<br>Office of the President<br>NATIONAL COMMISSION ON INDIGENOUS PEOPLES<br>Regional Office No. ____<br><br>REPORTS ON DISBURSEMENT*<br>NCIP-EAP ADMINISTRATIVE COST SY ___</p>',
                
                customize: function(win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape; }',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    $(win.document.body).find('table tbody td:nth-child(3)').css('text-align', 'right');
                    $(win.document.body).find('table tfoot th:nth-child(2)').css('text-align', 'right');
                    $(win.document.body).find('table tfoot th:nth-child(3)').css('text-align', 'right');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);
                }
                
            }, 'colvis']

        });

    });
</script>
@endpush