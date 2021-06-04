@extends('layouts.adminlte.template')
@section('title', 'Report of Graduates - Where Abouts')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Report of Graduates</h3>
    </div>
    <div class="card-body">

        <table id="graduateList" class="table table-sm table-bordered table-hover table-responsive-sm" style="width:100%">
            <thead>
                <tr>
                    <th>Region</th>
                    <th>Province</th>
                    <th>Name</th>
                    <th>Kind of EAP</th>
                    <th>Ethno Group</th>
                    <th class="sum">Male</th>
                    <th class="sum">Female</th>
                    <th>Course</th>
                    <th>Year Employed</th>
                    <th class="sum">FE</th>
                    <th class="sum">PE</th>
                    <th class="sum">SE</th>
                    <th class="sum">GO/NGO/CSO</th>
                    <th>Position</th>
                    <th>Employer Name</th>
                    <th>Place of Employment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $application)
                @if(!is_null($application->employment))
                @if(substr($application->applicant->psgcBrgy->code, 0, $subStrLen) == $locationId || $subStrLen == '0')
                <tr>
                    <td>{{ \App\Models\Psgc::getRegion($application->applicant->psgCode ?? '') }}</td>
                    <td>{{ \App\Models\Psgc::getProvince($application->applicant->psgCode ?? '') }}</td>
                    <td>{{ $application->applicant->lastName ?? '' }}, {{ $application->applicant->firstName ?? '' }} {{ ucwords(substr($application->applicant->middleName,0,'1')).'.' ?? '' }}</td>
                    <td>{{ $application->type }}</td>
                    <td>{{ \App\Models\Ethnogroup::getEthno($application->applicant->ethnoGroup ?? '') }}</td>
                    <td class="text-center text-bold">
                        @if (isset($application->applicant->gender))
                            @if ($application->applicant->gender == 'Male')
                                &#10003;
                            @endif
                        @endif
                    </td>
                    <td class="text-center text-bold">
                        @if (isset($application->applicant->gender))
                            @if ($application->applicant->gender == 'Female')
                                &#10003;
                            @endif
                        @endif
                    </td>
                    <td>{{ $application->course ?? '' }}</td>
                    <td>{{ $application->employment->yearEmployed }}</td>
                    <td class="text-center text-bold">@if ($application->employment->employerType=='FE') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->employment->employerType=='PE') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->employment->employerType=='SE') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->employment->employerType=='GO/NGO/CSO') &#10003; @endif</td>
                    <td>{{ $application->employment->position }}</td>
                    <td>{{ $application->employment->employerName }}</td>
                    <td>{{ $application->employment->employerAddress }}</td>
                </tr>
                @endif
                @endif
                @empty
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="text-right">TOTAL:</th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
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
        Note:<br>
        *FE - Fully Employed<br>
        *PE - Partially Employed<br>
        *SE - Self-Employed<br>
        *GO/NGO/CSO - Government Organization/ Non-Government Organization/ Civil Society Organization
    </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#graduateList').DataTable({
            stateSave: true,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "order": [],
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
                filename: 'Report_of_Graduates_(FORM_D)_{{ Auth::user()->name }}_{{ date('YmdHis') }}',
                title: '',
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                autoFilter: true,
                sheetName: 'Graduates Where-abouts',
                footer: true,
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                }
            }, {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                footer: true,
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                },
                autoPrint: false,
                title: '',
                messageTop: '<div class="row">' +
                    '<div class="col-4">' +
                    '<img src="{{asset('/images/app/NCIP_logo150x150.png')}}" style="width:100px; height:100px; float:right;" />' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-center">Republic of the Philippines<br>Office of the President<br><strong>NATIONAL COMMISSION ON INDIGENOUS PEOPLES</strong><br>' +
                    '{{ App\Models\Psgc::getRegion(Auth::user()->region) }}<br><br>' +
                    '<strong>REPORTS OF GRADUATES</strong><br> ' +
                    'School Year ____ <br>' +
                    'As of {{now()}}</p>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<p class="text-right">Form D</p>' +
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

                        $(win.document.body).find('table thead th').css({
                        'vertical-align': 'middle',
                        'text-align': 'center'
                    });

                    $(win.document.body).find('table tbody td:nth-child(6)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(7)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(10)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(11)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(12)').css('text-align', 'center');
                    $(win.document.body).find('table tbody td:nth-child(13)').css('text-align', 'center');

                    $(win.document.body).find('table tfoot th').css({
                        'vertical-align': 'middle',
                        'text-align': 'center'
                    });
                    $(win.document.body).find('table tfoot th:nth-child(5)').css('text-align', 'right');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);
                }
            }, 'colvis'],
        });

    });
</script>
@endpush
