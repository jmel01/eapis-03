@extends('layouts.adminlte.template')

@section('title', 'Activity Logs')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Activity Logs</h3>
    </div>
    <div class="card-body">
        <button class="btn btn-outline-danger btn-sm btn-delete-logs float-right">DELETE ALL LOGS</button>
        <table id="activityLogList" class="table table-sm table-hover table-responsive-sm">
            <thead>
                <tr>
                    <th>Model Name</th>
                    <th>Row</th>
                    <th>Event</th>
                    <th>Before</th>
                    <th>After</th>
                    <th>Username</th>
                    <th>Event Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activity as $log)
                <tr>
                    <td>{{ $log->log_name }}</td>
                    <td>{{ $log->subject_id }}</td>
                    <td>
                        @if($log->description == 'created')
                        <span class="badge badge-success">{{ $log->description }}</span>
                        @elseif($log->description == 'updated')
                        <span class="badge badge-primary">{{ $log->description }}</span>
                        @else
                        <span class="badge badge-danger">{{ $log->description }}</span>
                        @endif
                    </td>

                    <td>
                        @if(isset($log->properties['old']))
                        @foreach($log->properties['old'] as $keyOld => $valueOld)
                        <span class="badge badge-light mr-2">{{$keyOld}}:</span>{{$valueOld}} <br>
                        @endforeach
                        @endif
                    </td>

                    <td>
                        @if(isset($log->properties['attributes']))
                        @foreach($log->properties['attributes'] as $keyAttribute => $valueAttribute)
                        <span class="badge badge-light mr-2">{{$keyAttribute}}:</span>{{$valueAttribute}} <br>
                        @endforeach
                        @endif
                    </td>

                    <td>{{\App\Models\User::find($log->causer_id)->name ?? ''}}</td>
                    <td>{{date('F d, Y - h:i A', strtotime($log->created_at))}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
    <div class="card-footer">

    </div>
</div>

{{-- !-- Delete Warning Activity Modal -->  --}}
<div class="modal fade" id="modalDeleteActivity">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete all logs?</p>
                <button type="button" class="btn btn-default btn-sm float-right" data-dismiss="modal">Cancel</button>
                <a href="/activity-logs/clear" class="btn btn-outline-danger btn-sm btn-add-user mr-1 float-right">Confirm</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        $('.btn-delete-logs').click(function() {
            $('#modalDeleteActivity').modal('show')
        });

        // Create DataTable
        var table = $('#activityLogList').DataTable({
            "order": [],
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
                filename: 'Activity Logs',
                title: '',
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
                    '<p class="text-center">Republic of the Philippines<br>Office of the President<br>NATIONAL COMMISSION ON INDIGENOUS PEOPLES<br></p>' +

                    '<h3 class="text-center">ACTIVITY LOGS</h3>' +
                    '<p class="text-center">As of {{now()}}</p>' +
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

                }
            }, 'colvis']
        });

    })
</script>
@endpush