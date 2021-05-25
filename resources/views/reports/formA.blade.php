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

        <table id="granteeList" class="table table-sm table-bordered table-hover table-responsive-sm" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Region</th>
                    <th class="text-center">Province</th>
                    <th class="sum">MBS</th>
                    <th class="sum">Regular</th>
                    <th class="sum">PAMANA</th>
                    <th class="sum">Elementary</th>
                    <th class="sum">High School</th>
                    <th class="sum">Vocational</th>
                    <th class="sum">College</th>
                    <th class="sum">Post Study</th>
                    <th class="sum">FSD</th>
                    <th class="sum">FG</th>
                    <th class="sum">DS</th>
                    <th class="sum">NE</th>
                    <th class="sum">FPD</th>
                    <th class="sum">EOGS</th>
                    <th class="sum">Other</th>
                    <th class="sum">Total</th>
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
                    <th class="text-right">TOTAL:</th>
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
        Note:<br>
        *FSD - Failure to Submit Documents<br>
        *FG - Failing Grades<br>
        *DS - Dropped Subjects<br>
        *NE - Not Enrolled<br>
        *FPD - Falsification of Public Documents<br>
        *EOGS - Enjoying Other Government Scholarship<br>
        *Others
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#granteeList').DataTable({
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

                    this.footer().innerHTML = pageSum;
                });
            },

            dom: '<"row"<"col-md-12 mb-3"B>>' +
                '<"row"<"col-md-5"l><"col-md-7"f>>' +
                '<"row"<"col-md-12"t>>' +
                '<"row"<"col-md-5"i><"col-md-7"p>>' +
                '<"row"<"col-md-6"Q>>',

            buttons: [{
                filename: 'Summary_of_Grant_or_Award_Status_(FORM_A)_{{ Auth::user()->name }}_{{ date('YmdHis') }}',
                title: '',
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                autoFilter: true,
                sheetName: 'Summary of Grant/Award Status',
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
                    '<img src="/images/app/NCIP_logo150x150.png" style="width:100px; height:100px; float:right;" />' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-center">Republic of the Philippines<br>Office of the President<br><strong>NATIONAL COMMISSION ON INDIGENOUS PEOPLES</strong><br>' +
                    '{{ App\Models\Psgc::getRegion(Auth::user()->region) }}<br><br>' +
                    '<strong>Summary of Grant/Award Status</strong><br> ' +
                    'School Year ____ <br>' +
                    'As of {{now()}}</p>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-right">Form A</p>' +
                    '</div>' +
                    '</div>',

                messageBottom: '<div class="row mt-5">' +
                '<div class="col-12">' +
                    '<p class="text-left text-sm">This report was generated using Educational Assistance Program Information System on {{ date('Y/m/d H:i:s') }} by {{ Auth::user()->name }};<p>' +
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

                    $(win.document.body).find('table tfoot th').css({
                        'vertical-align': 'middle',
                        'text-align': 'center'
                    });
                    $(win.document.body).find('table tfoot th:nth-child(2)').css('text-align', 'right');

                }
            }, 'colvis']

        });

    });
</script>
@endpush