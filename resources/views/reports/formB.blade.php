@extends('layouts.adminlte.template')
@section('title', 'Report of Graduates')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />

@endpush
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Report of Graduates</h3>
    </div>
    <div class="card-body">

        <table id="graduateList" class="table table-sm table-bordered table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Kind of EAP/Name</th>
                    <th>Ethno Group</th>
                    <th class="sum">Male</th>
                    <th class="sum">Female</th>
                    <th>Age</th>
                    <th>School</th>
                    <th>Course</th>
                    <th class="sum">College</th>
                    <th class="sum">Vocational</th>
                    <th class="sum">High School</th>
                    <th class="sum">Elementary</th>
                    <th>No. of Years Availed</th>
                    <th>Province/District</th>
                    <th>Region</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $application)
                @if(isset($application->applicant))
                <tr>
                    <td>{{ $application->applicant->lastName }}, {{ $application->applicant->firstName }} {{ substr($application->applicant->middleName, 0,  1) }}.</td>
                    <td>{{ App\Models\Ethnogroup::find($application->applicant->ethnoGroup)->ipgroup }}</td>
                    <td class="text-center text-bold">@if ($application->applicant->gender=='Male') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->applicant->gender=='Female') &#10003; @endif</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($application->applicant->birthdate)->diff(\Carbon\Carbon::now())->format('%y') }}</td>
                    <td>{{ $application->school }}</td>
                    <td>{{ $application->course }}</td>
                    <td class="text-center text-bold">@if ($application->level=='College') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->level=='Vocational') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->level=='High School') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->level=='Elementary') &#10003; @endif</td>
                    <td></td>
                    <td>{{ App\Models\Psgc::getProvince($application->applicant->psgCode) }}</td>
                    <td>{{ App\Models\Psgc::getRegion($application->applicant->psgCode) }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th class="text-right">TOTAL:</th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#graduateList').DataTable({
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

                api.columns('.sum', {
                    page: 'current'
                }).every(function() {
                    let count = 0;
                    var pageSum = this
                        .data()
                        .reduce(function(a, b) {
                            b == '' ? '' : count++;
                            return count;
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
                title: 'Report of Graduates (FORM B)',
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
                messageTop: '<div class="row">' +
                    '<div class="col-4">' +
                    '<img src="/images/app/NCIP_logo150x150.png" style="width:100px; height:100px; float:right;" />' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-center">Republic of the Philippines<br>Office of the President<br><strong>NATIONAL COMMISSION ON INDIGENOUS PEOPLES</strong><br>' +
                    '{{ App\Models\Psgc::getRegion(Auth::user()->region) }}<br><br>' +
                    '<strong>REPORTS OF GRADUATES</strong><br> ' +
                    'School Year ____ <br>' +
                    'As of {{now()}}</p>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-right">Form B</p>' +
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

                    $(win.document.body).find('table thead th').css({
                        'vertical-align': 'middle',
                        'text-align': 'center'
                    });

                    $(win.document.body).find('table tbody td:nth-child(3)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(4)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(5)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(8)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(9)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(10)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(11)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(12)').css('text-align', 'center');

                    $(win.document.body).find('table tfoot th').css({
                        'vertical-align': 'middle',
                        'text-align': 'center'
                    });
                    $(win.document.body).find('table tfoot th:nth-child(2)').css('text-align', 'right');

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