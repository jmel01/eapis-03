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
                @foreach($data['applicant'] as $key => $value)
                @php $total=0 @endphp
                <tr>
                    <td>{{App\Models\Psgc::getRegion($value->code)}}</td>
                    <td>{{App\Models\Psgc::getProvince($value->code)}}</td>

                    <td class="text-center">
                        @foreach($level['mbs'] as $mbs)
                        @if($mbs->code == $value->code)
                        {{ $mbs->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['regular'] as $regular)
                        @if($regular->code == $value->code)
                        {{ $regular->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['pamana'] as $pamana)
                        @if($pamana->code == $value->code)
                        {{ $pamana->levelCount }}
                        @endif
                        @endforeach
                    </td>

                    <td class="text-center">
                        @foreach($level['elementary'] as $elementary)
                        @if($elementary->code == $value->code)
                        {{ $elementary->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['highSchool'] as $highSchool)
                        @if($highSchool->code == $value->code)
                        {{ $highSchool->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['vocational'] as $vocational)
                        @if($vocational->code == $value->code)
                        {{ $vocational->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['college'] as $college)
                        @if($college->code == $value->code)
                        {{ $college->levelCount }}
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['postStudy'] as $postStudy)
                        @if($postStudy->code == $value->code)
                        {{ $postStudy->levelCount }}
                        @endif
                        @endforeach
                    </td>

                    <td class="text-center">
                        @foreach($level['FSD'] as $FSD)
                        @if($FSD->code == $value->code)
                        {{ $FSD->levelCount }}
                        @php $total += $FSD->levelCount @endphp
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['FG'] as $FG)
                        @if($FG->code == $value->code)
                        {{ $FG->levelCount }}
                        @php $total += $FG->levelCount @endphp
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['DS'] as $DS)
                        @if($DS->code == $value->code)
                        {{ $DS->levelCount }}
                        @php $total += $DS->levelCount @endphp
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['NE'] as $NE)
                        @if($NE->code == $value->code)
                        {{ $NE->levelCount }}
                        @php $total += $NE->levelCount @endphp
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['FPD'] as $FPD)
                        @if($FPD->code == $value->code)
                        {{ $FPD->levelCount }}
                        @php $total += $FPD->levelCount @endphp
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['EOGS'] as $EOGS)
                        @if($EOGS->code == $value->code)
                        {{ $EOGS->levelCount }}
                        @php $total += $EOGS->levelCount @endphp
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($level['OTHER'] as $OTHER)
                        @if($OTHER->code == $value->code)
                        {{ $OTHER->levelCount }}
                        @php $total += $OTHER->levelCount @endphp
                        @endif
                        @endforeach
                    </td>

                    <td class="text-center">{{$total}}</td>
                    <td></td>
                </tr>
                @endforeach
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
            "fixedHeader": {
                header: true,
                footer: true
            },



            "drawCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over this page
                var pagembsTotal = api
                    .column(2, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pageregTotal = api
                    .column(3, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pagepamanaTotal = api
                    .column(4, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pageelemTotal = api
                    .column(5, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pagehsTotal = api
                    .column(6, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pagevocTotal = api
                    .column(7, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var pagecollegeTotal = api
                    .column(8, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pagepostTotal = api
                    .column(9, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pagefsdTotal = api
                    .column(10, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pagefgTotal = api
                    .column(11, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pagedsTotal = api
                    .column(12, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pageneTotal = api
                    .column(13, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pagefpdTotal = api
                    .column(14, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pageeogsTotal = api
                    .column(15, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pageotherTotal = api
                    .column(16, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pagerowTotal = api
                    .column(17, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over all page
                var mbsTotal = api
                    .column(2)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var regTotal = api
                    .column(3)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var pamanaTotal = api
                    .column(4)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var elemTotal = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var hsTotal = api
                    .column(6)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var vocTotal = api
                    .column(7)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var collegeTotal = api
                    .column(8)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var postTotal = api
                    .column(9)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var fsdTotal = api
                    .column(10)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var fgTotal = api
                    .column(11)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var dsTotal = api
                    .column(12)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var neTotal = api
                    .column(13)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var fpdTotal = api
                    .column(14)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var eogsTotal = api
                    .column(15)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var otherTotal = api
                    .column(16)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var rowTotal = api
                    .column(17)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);



                // Update footer by showing the total with the reference of the column index 
                $(api.column(1).footer()).html('Total:');
                $(api.column(2).footer()).html(
                    pagembsTotal.toLocaleString("en-US") + ' ( ' + mbsTotal.toLocaleString("en-US") + ')'
                );
                $(api.column(3).footer()).html(pageregTotal);
                $(api.column(4).footer()).html(pagepamanaTotal);
                $(api.column(5).footer()).html(pageelemTotal);
                $(api.column(6).footer()).html(pagehsTotal);
                $(api.column(7).footer()).html(pagevocTotal);
                $(api.column(8).footer()).html(pagecollegeTotal);
                $(api.column(9).footer()).html(pagepostTotal);
                $(api.column(10).footer()).html(pagefsdTotal);
                $(api.column(11).footer()).html(pagefgTotal);
                $(api.column(12).footer()).html(pagedsTotal);
                $(api.column(13).footer()).html(pageneTotal);
                $(api.column(14).footer()).html(pagefpdTotal);
                $(api.column(15).footer()).html(pageeogsTotal);
                $(api.column(16).footer()).html(pageotherTotal);
                $(api.column(17).footer()).html(
                    pagerowTotal.toLocaleString("en-US") + ' ( ' + rowTotal.toLocaleString("en-US") + ')'
                );
            },

            //dom: 'BlftipQ',

            dom: '<"row"<"col-md-12 mb-3"B>>' +
                '<"row"<"col-md-5"l><"col-md-7"f>>' +
                '<"row"<"col-md-12"t>>' +
                '<"row"<"col-md-5"i><"col-md-7"p>>' +
                '<"row"<"col-md-6"Q>>',

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
                    page: "current",
                    columns: ':visible'
                },
                autoPrint: false,
                title: '',
                footer: true,
                messageTop: '<div class="row">' +
                    '<div class="col-4">' +
                    '<img src="/images/app/NCIP_logo150x150.png" style="width:100px; height:100px; float:right;" />' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-center">Republic of the Philippines<br>Office of the President<br>NATIONAL COMMISSION ON INDIGENOUS PEOPLES<br>' +
                    'Regional Office No. ____<br><br>' +
                    'Summary of Grant/Award Status<br> ' +
                    'School Year ____</p>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-right">Form A</p>' +
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