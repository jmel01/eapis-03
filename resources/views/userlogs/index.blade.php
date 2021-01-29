@extends('layouts.adminlte.template')

@section('title', 'User Logs')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">User Logs</h3>
    </div>
    <div class="card-body">
        <table id="userLogList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Date and Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($auditEvents as $auditEvent)
                    <tr>
                        <td>{{$auditEvent->auditTrail->user->name}}</td>
                        <td>{{$auditEvent->event_type}}</td>
                        <td>{{date('F d, Y - h:i A', strtotime($auditEvent->created_at))}}</td>
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
        var table = $('#userLogList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

    })
</script>

@endpush