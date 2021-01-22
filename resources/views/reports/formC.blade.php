@extends('layouts.adminlte.template')
@section('title', 'Report of Termination')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />

@endpush
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Report of Termination</h3>
    </div>
    <div class="card-body">

        <table id="teminatedList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Province</th>
                    <th>Kind of EAP</th>
                    <th>Name</th>
                    <th>FSD</th>
                    <th>FG</th>
                    <th>DS</th>
                    <th>NE</th>
                    <th>FPD</th>
                    <th>EOGS</th>
                    <th>OTHER</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $application)
                <tr>
                    <td>{{ App\Models\Psgc::getProvince($application->applicant->psgCode) }}</td>
                    <td>{{ $application->type }}</td>
                    <td>{{ $application->applicant->lastName }}, {{ $application->applicant->firstName }} {{ substr($application->applicant->middleName, 0,  3) }}</td>
                    <td class="text-center text-bold">@if ($application->status=='Terminated-FSD') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->status=='Terminated-FG') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->status=='Terminated-DS') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->status=='Terminated-NE') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->status=='Terminated-FPD') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->status=='Terminated-EOGS') &#10003; @endif</td>
                    <td class="text-center text-bold">@if ($application->status=='Terminated-Others') &#10003; @endif</td>
                </tr>
                @endforeach
            </tbody>
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
        var table = $('#teminatedList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            dom: 'Bfrtip',
            buttons: [
                'excel', {
                    extend: 'print',
                    autoPrint: false,
                    title: '',
                    messageTop: '<p class="text-right">Form C</p><p class="text-center">Republic of the Philippines<br>Office of the President<br>NATIONAL COMMISSION ON INDIGENOUS PEOPLES<br>Regional Office No. ____<br><br>REPORTS OF TERMINATION<br>SY ___<br>As of Month, Year</p>',
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
                }
            ]
        });

    });
</script>
@endpush
