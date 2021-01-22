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

        <table id="costList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Province/District</th>
                    <th>Elementary</th>
                    <th>High School</th>
                    <th>Vocational</th>
                    <th>College</th>
                    <th>Administrative Cost</th>
                    <th>Actual Amount Disburse to Grantees</th>
                    <th>Total</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $cost)
                <tr>
                    <td>{{ $cost->province }}</td>
                    <td class="text-right">1</td>
                    <td class="text-right">1</td>
                    <td class="text-right">1</td>
                    <td class="text-right">1</td>
                    <td class="text-right">{{ number_format($cost->amount, 2, '.', ',') }}</td>
                    <td class="text-right">{{ number_format($cost->amount, 2, '.', ',') }}</td>
                    <td class="text-right"></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
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

                // computing column Total of the complete result 
                var elemTotal = api
                    .column(1)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var hsTotal = api
                    .column(2)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var vocTotal = api
                    .column(3)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var collegeTotal = api
                    .column(4)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var adminCostTotal = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var disburseToGranteeTotal = api
                    .column(6)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var rowTotal = api
                    .column(7)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);


                // Update footer by showing the total with the reference of the column index 
                $(api.column(0).footer()).html('Total');
                $(api.column(1).footer()).html(elemTotal);
                $(api.column(2).footer()).html(hsTotal);
                $(api.column(3).footer()).html(vocTotal);
                $(api.column(4).footer()).html(collegeTotal);
                $(api.column(5).footer()).html(adminCostTotal);
                $(api.column(6).footer()).html(disburseToGranteeTotal);
                $(api.column(7).footer()).html(rowTotal);
            },

            dom: 'Bfrtip',
            buttons: [
                'excel', {
                    extend: 'print',
                    autoPrint: false,
                    title: '',
                    footer: true,
                    messageTop: '<p class="text-right">Form F</p><p class="text-center">Republic of the Philippines<br>Office of the President<br>NATIONAL COMMISSION ON INDIGENOUS PEOPLES<br>Regional Office No. ____<br><br>SUMMARY OF ACTUAL DISBURSEMENT<br>School Year ___<br>as of Date</p>',
                    customize: function(win) {
                        $(win.document.body).find('table thead th:nth-child(1)').css('text-align', 'center');
                        $(win.document.body).find('table thead th:nth-child(2)').css('text-align', 'center');
                        $(win.document.body).find('table thead th:nth-child(3)').css('text-align', 'center');
                        $(win.document.body).find('table thead th:nth-child(4)').css('text-align', 'center');
                        $(win.document.body).find('table thead th:nth-child(5)').css('text-align', 'center');
                        $(win.document.body).find('table thead th:nth-child(6)').css('text-align', 'center');
                        $(win.document.body).find('table thead th:nth-child(7)').css('text-align', 'center');
                        $(win.document.body).find('table thead th:nth-child(8)').css('text-align', 'center');
                        $(win.document.body).find('table thead th:nth-child(9)').css('text-align', 'center');

                        $(win.document.body).find('table tbody td:nth-child(1)').css('text-align', 'center');
                        $(win.document.body).find('table tbody td:nth-child(2)').css('text-align', 'right');
                        $(win.document.body).find('table tbody td:nth-child(3)').css('text-align', 'right');
                        $(win.document.body).find('table tbody td:nth-child(4)').css('text-align', 'right');
                        $(win.document.body).find('table tbody td:nth-child(5)').css('text-align', 'right');
                        $(win.document.body).find('table tbody td:nth-child(6)').css('text-align', 'right');
                        $(win.document.body).find('table tbody td:nth-child(7)').css('text-align', 'right');
                        $(win.document.body).find('table tbody td:nth-child(8)').css('text-align', 'right');

                        $(win.document.body).find('table tfoot th:nth-child(1)').css('text-align', 'right');
                        $(win.document.body).find('table tfoot th:nth-child(2)').css('text-align', 'right');
                        $(win.document.body).find('table tfoot th:nth-child(3)').css('text-align', 'right');
                        $(win.document.body).find('table tfoot th:nth-child(4)').css('text-align', 'right');
                        $(win.document.body).find('table tfoot th:nth-child(5)').css('text-align', 'right');
                        $(win.document.body).find('table tfoot th:nth-child(6)').css('text-align', 'right');
                        $(win.document.body).find('table tfoot th:nth-child(7)').css('text-align', 'right');
                        $(win.document.body).find('table tfoot th:nth-child(8)').css('text-align', 'right');
                        var last = null;
                        var current = null;
                        var bod = [];

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

                    }
                }
            ]

        });

    });
</script>
@endpush