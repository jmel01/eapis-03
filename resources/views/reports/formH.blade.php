@extends('layouts.adminlte.template')
@section('title', 'Monitoring of EAP Documents')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />

@endpush
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Monitoring of EAP Documents</h3>
    </div>
    <div class="card-body">

        <table id="documentList" class="table table-sm table-bordered table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Region</th>
                    <th>Province</th>
                    <th>Name</th>
                    <th>Ethno Group</th>
                    <th>CTM/COC</th>
                    <th>ITR</th>
                    <th>Application Form</th>
                    <th>CE (1st Sem)</th>
                    <th>COG (1st Sem)</th>
                    <th>CE (2nd Sem)</th>
                    <th>COG (2nd Sem)</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
    <div class="card-footer">
      
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
        var table = $('#documentList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "order": [],

            dom: 'BfrtipQ',
            buttons: [{
                title: 'Monitoring of EAP Documents (FORM H)',
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
                messageTop: '<p class="text-right">Form H</p><p class="text-center">Republic of the Philippines<br>Office of the President<br>NATIONAL COMMISSION ON INDIGENOUS PEOPLES<br>Regional Office No. ____<br><br>Monitoring of EAP Documents<br>School Year ____</p>',
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