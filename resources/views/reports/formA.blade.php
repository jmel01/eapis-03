@extends('layouts.adminlte.template')
@section('title', 'Summary of Grant/Award Status')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />

@endpush
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Summary of Grant/Award Status</h3>
    </div>
    <div class="card-body">

        <table id="costList" class="table table-sm table-bordered table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th class="text-center">Region</th>
                    <th class="text-center">Province</th>
                    <th>MBS</th>
                    <th>Regular</th>
                    <th>PAMANA</th>
                    <th>Elementary</th>
                    <th>High School</th>
                    <th>Vocational</th>
                    <th>College</th>
                    <th>Post Study</th>
                    <th>FSD</th>
                    <th>FG</th>
                    <th>DS</th>
                    <th>NE</th>
                    <th>FPD</th>
                    <th>EOGS</th>
                    <th>Other</th>
                    <th>Total</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <td>1</td>
                <td>2</td>
                <td class="text-center">3</td>
                <td class="text-center">4</td>
                <td class="text-center">5</td>
                <td class="text-center">6</td>
                <td class="text-center">7</td>
                <td class="text-center">8</td>
                <td class="text-center">9</td>
                <td class="text-center">8</td>
                <td class="text-center">7</td>
                <td class="text-center">5</td>
                <td class="text-center">6</td>
                <td class="text-center">4</td>
                <td class="text-center">3</td>
                <td class="text-center">2</td>
                <td class="text-center">1</td>
                <td class="text-center">1</td>
                <td>1</td>

            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th class="text-right"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
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

                // computing column Total of the complete result 
                var mbsTotal = api
                    .column(2, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var regTotal = api
                    .column(3, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pamanaTotal = api
                    .column(4, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var elemTotal = api
                    .column(5, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var hsTotal = api
                    .column(6, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var vocTotal = api
                    .column(7, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var collegeTotal = api
                    .column(8, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var postTotal = api
                    .column(9, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var fsdTotal = api
                    .column(10, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var fgTotal = api
                    .column(11, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var dsTotal = api
                    .column(12, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var neTotal = api
                    .column(13, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var fpdTotal = api
                    .column(14, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var eogsTotal = api
                    .column(15, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var otherTotal = api
                    .column(16, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var rowTotal = api
                    .column(17, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);



                // Update footer by showing the total with the reference of the column index 
                $(api.column(1).footer()).html('Total:');
                $(api.column(2).footer()).html(mbsTotal);
                $(api.column(3).footer()).html(regTotal);
                $(api.column(4).footer()).html(pamanaTotal);
                $(api.column(5).footer()).html(elemTotal);
                $(api.column(6).footer()).html(hsTotal);
                $(api.column(7).footer()).html(vocTotal);
                $(api.column(8).footer()).html(collegeTotal);
                $(api.column(9).footer()).html(fsdTotal);
                $(api.column(10).footer()).html(fgTotal);
                $(api.column(11).footer()).html(dsTotal);
                $(api.column(12).footer()).html(neTotal);
                $(api.column(13).footer()).html(fpdTotal);
                $(api.column(14).footer()).html(fpdTotal);
                $(api.column(15).footer()).html(eogsTotal);
                $(api.column(16).footer()).html(otherTotal);
                $(api.column(17).footer()).html(rowTotal);
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
                messageTop: '<p class="text-right">Form A</p><p class="text-center">Republic of the Philippines<br>Office of the President<br>NATIONAL COMMISSION ON INDIGENOUS PEOPLES<br>Regional Office No. ____<br><br>Summary of Grant/Award Status<br> School Year ____</p>',
                customize: function(win) {
                   
                    $(win.document.body).find('table thead th:nth-child(3)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(4)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(5)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(6)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(7)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(8)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(9)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(10)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(11)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(12)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(13)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(14)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(15)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(16)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(17)').css('text-align', 'center');
                    $(win.document.body).find('table thead th:nth-child(18)').css('text-align', 'center');

                    $(win.document.body).find('table tbody td:nth-child(3)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(4)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(5)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(6)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(7)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(8)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(9)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(10)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(11)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(12)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(13)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(14)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(15)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(16)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(17)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(18)').css('text-align', 'center');

                    $(win.document.body).find('table tfoot th:nth-child(2)').css('text-align', 'right');
                    $(win.document.body).find('table tfoot th:nth-child(3)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(4)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(5)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(6)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(7)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(8)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(9)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(10)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(11)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(12)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(13)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(14)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(15)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(16)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(17)').css('text-align', 'center');
                    $(win.document.body).find('table tfoot th:nth-child(18)').css('text-align', 'center');

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
            }, 'colvis']

        });

    });
</script>
@endpush