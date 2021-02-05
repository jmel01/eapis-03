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
                    <th>Male</th>
                    <th>Female</th>
                    <th>Age</th>
                    <th>School</th>
                    <th>Course</th>
                    <th>College</th>
                    <th>Vocational</th>
                    <th>High School</th>
                    <th>Elementary</th>
                    <th>No. of Years Availed</th>
                    <th>Province/District</th>
                    <th>Region</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $application)
                <tr>
                    <td>{{ $application->applicant->lastName }}, {{ $application->applicant->firstName }} {{ substr($application->applicant->middleName, 0,  1) }}.</td>
                    <td>{{ App\Models\Ethnogroup::find($application->applicant->ethnoGroup)->ipgroup }}</td>
                    <td class="text-center text-bold">@if ($application->applicant->gender=='Male') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->applicant->gender=='Female') &#10003; @endif</td>
                    <td>{{ $application->applicant->birthdate }}</td>
                    <td>{{ $application->school }}</td>
                    <td>{{ $application->course }}</td>
                    <td class="text-center text-bold">@if ($application->level=='College') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->level=='Vocational') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->level=='High School') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->level=='Elementary') &#10003; @endif</td>
                    <td></td>
                    <td>{{ App\Models\Psgc::getRegion($application->applicant->psgCode) }}</td>
                    <td>{{ App\Models\Psgc::getProvince($application->applicant->psgCode) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th class="text-center text-bold"></th>
                    <th class="text-center text-bold"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="text-center text-bold"></th>
                    <th class="text-center text-bold"></th>
                    <th class="text-center text-bold"></th>
                    <th class="text-center text-bold"></th>
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
                    return typeof i != '' ? 1 : 0;
                };

                // computing column Total of the complete result 

                let countmale = 0;
                var male = api
                    .column(2)
                    .data()
                    .reduce(function(a, b) {
                        b == '' ? '' : countmale++;
                        return countmale;
                    }, 0);

                let countfemale = 0;
                var female = api
                    .column(3)
                    .data()
                    .reduce(function(a, b) {
                        b == '' ? '' : countfemale++;
                        return countfemale;
                    }, 0);

                let countcollege = 0;
                var college = api
                    .column(7)
                    .data()
                    .reduce(function(a, b) {
                        b == '' ? '' : countcollege++;
                        return countcollege;
                    }, 0);

                let countvocational = 0;    
                var vocational = api
                    .column(8)
                    .data()
                    .reduce(function(a, b) {
                        b == '' ? '' : countvocational++;
                        return countvocational;
                    }, 0);

                
                let counthighSchool = 0; 
                var highSchool = api
                    .column(9)
                    .data()
                    .reduce(function(a, b) {
                        b == '' ? '' : counthighSchool++;
                        return counthighSchool;
                    }, 0);

                let countelementary = 0; 
                var elementary = api
                    .column(10)
                    .data()
                    .reduce(function(a, b) {
                        b == '' ? '' : countelementary++;
                        return countelementary;
                    }, 0);


                // Update footer by showing the total with the reference of the column index 
                $(api.column(1).footer()).html('Total');
                $(api.column(2).footer()).html(male);
                $(api.column(3).footer()).html(female);
                $(api.column(7).footer()).html(college);
                $(api.column(8).footer()).html(vocational);
                $(api.column(9).footer()).html(highSchool);
                $(api.column(10).footer()).html(elementary);
            },
            dom: 'BfrtipQ',
            buttons: [{
                title: 'Report of Graduates (FORM B)',
                extend: 'excelHtml5',
                footer: true,
                exportOptions: {
                    columns: ':visible'

                }
            }, {
                extend: 'print',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                },
                autoPrint: false,
                title: '',
                messageTop: '<p class="text-right">Form B</p><p class="text-center">Republic of the Philippines<br>Office of the President<br>NATIONAL COMMISSION ON INDIGENOUS PEOPLES<br>Regional Office No. ____<br><br>REPORTS OF GRADUATES<br>SY ___<br>As of Month, Year</p>',
                customize: function(win) {

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