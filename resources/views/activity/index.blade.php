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
    <a href="/activity-logs/clear" class="btn btn-outline-danger btn-sm btn-add-user float-right">DELETE ALL LOGS</a>
        <table id="activityLogList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Model Name</th>
                    <th>Row</th>
                    <th>Event</th>
                    <th>Before</th>
                    <th>After</th>
                    <th>User</th>
                    <th>Event Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activity as $log)
                <tr>
                    <td>{{ $log->subject_type }}</td>
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
                        @foreach($log->properties['attributes'] as $keyAttribute => $valueAttribute)
                        <span class="badge badge-light mr-2">{{$keyAttribute}}:</span>{{$valueAttribute}} <br>
                        @endforeach
                    </td>
                    
                    <td>{{\App\Models\User::find($log->causer_id)->name ?? ''}}</td>
                    <td>{{date('F d, Y - h:i A', strtotime($log->created_at))}}</td>
                </tr>
                @endforeach
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
        var table = $('#activityLogList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "order": [[ 6, "desc" ]],
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

    })
</script>

@endpush