@extends('layouts.adminlte.template')

@section('title', 'Scholarship/Grant Management')

@push('style')
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Scholarship/Grant</h3>
    </div>
    <div class="card-body">
        @can('grant-add')
        <button class="btn btn-outline-primary btn-sm btn-add-grant float-right">ADD NEW GRANT</button>
        @endcan
        <table id="grantList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Grant ID</th>
                    <th>Region</th>
                    <th>Academic Year</th>
                    <th>Application Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $grant)
                <tr>
                    <td>{{ $grant->id }}</td>
                    <td>
                        @foreach($regions as $region)
                        {{$region->code == $grant->region ? $region->name:'' }}
                        @endforeach
                    </td>
                    <td>{{ $grant->acadYr }}-{{ $grant->acadYr + 1 }}</td>

                    <td>
                        @if ($grant->applicationOpen <= date('Y-m-d') && $grant->applicationClosed >= date('Y-m-d'))
                            {{ date('d M. Y', strtotime($grant->applicationOpen)) }} to
                            {{ date('d M. Y', strtotime($grant->applicationClosed)) }} <strong
                                class="text-success">(Open)</strong>
                            @elseif ($grant->applicationOpen > date('Y-m-d'))
                            {{ date('d M. Y', strtotime($grant->applicationOpen)) }} to
                            {{ date('d M. Y', strtotime($grant->applicationClosed)) }} <strong
                                class="text-info">(Upcoming)</strong>
                            @else
                            {{ date('d M. Y', strtotime($grant->applicationOpen)) }} to
                            {{ date('d M. Y', strtotime($grant->applicationClosed)) }} <strong
                                class="text-danger">(Closed)</strong>
                            @endif
                    </td>
                    <td>
                        @can('application-browse')
                        <div class="btn-group mr-1" role="group">
                            <a href="{{ route('applications.show',$grant->id) }}" type="button"
                                class="btn btn-info btn-sm">Applications</a>

                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-info dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="{{ route('showApproved',$grant->id) }}">Approved</a>
                                    <a class="dropdown-item" href="{{ route('showOnProcess',$grant->id) }}">On Process</a>
                                    <a class="dropdown-item" href="{{ route('showTerminated',$grant->id) }}">Terminated</a>
                                </div>
                            </div>
                        </div>
                        @endcan
                        @can('expenses-browse')
                        <a href="{{ route('costs.show',$grant->id) }}" class="btn btn-primary btn-sm mr-1">Admin Cost</a>
                        @endcan
                        @can('grant-edit')
                        <button data-url="{{ route('grants.edit',$grant->id) }}"
                            class="btn btn-primary btn-sm mr-1 btn-edit-grant">Edit</button>
                        @endcan

                        @can('grant-delete')
                        <button data-url="{{ route('grants.destroy', $grant->id) }}"
                            class="btn btn-danger btn-sm mr-1 btn-delete-grant">Delete</button>
                        @endcan

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="card-footer">
        Footer
    </div>
</div>

@include('grants.modalGrant')
@include('layouts.adminlte.modalDelete')

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js">
</script>

<script>
$(document).ready(function() {
    // Create DataTable
    var table = $('#grantList').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });

    $('.btn-add-grant').click(function() {
        document.getElementById("formGrant").reset();
        $('[name="id"]').val('')
        $('#modalGrant').modal('show')

    });

    $('.btn-edit-grant').click(function() {
        var url_id = $(this).attr('data-url');
        $.get(url_id, function(data) {
            console.log(data)
            $('[name="id"]').val(data.grants.id)
            $('[name="region"]').val(data.grants.region)
            $('[name="acadYr"]').val(data.grants.acadYr)
            $('[name="acadYrEnd"]').val(parseInt(data.grants.acadYr) + 1)
            $('[name="applicationOpen"]').val(data.grants.applicationOpen)
            $('[name="applicationClosed"]').val(data.grants.applicationClosed)

            $('#modalGrant').modal('show')
        })
    })

    $('.btn-delete-grant').click(function() {
        var url_id = $(this).attr('data-url');
        document.getElementById("formDelete").action = url_id;
        $('#modalDelete').modal('show')

    });
});

function acadYrChange() {
    var x = parseInt(document.getElementById("acadYr").value) + 1;
    $('input[name="acadYrEnd"]').val(x);
}
</script>

<!-- Error/Modal Opener -->
@if (count($errors->grant) > 0)
<script type="text/javascript">
$(document).ready(function() {
    $('#modalGrant').modal('show');
});
</script>
@endif

@endpush